<?php
require 'vendor/autoload.php'; // Sesuaikan path ini jika perlu

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;

// Include file konfigurasi database
require_once 'config.php';

// Fungsi untuk mengubah nama hari menjadi bahasa Indonesia
function getDayName($date) {
    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    $dayOfWeek = date('N', strtotime($date)); // Mendapatkan indeks hari dalam seminggu (1: Senin, ..., 7: Minggu)
    return $days[$dayOfWeek - 1];
}

// Ambil nilai kelas dan bulan dari formulir
if (isset($_POST['class']) && isset($_POST['month'])) {
    $selectedClass = $_POST['class'];
    $selectedMonth = $_POST['month'];

    // Tentukan awal dan akhir bulan berdasarkan bulan yang dipilih
    $startDate = date('Y-m-01', strtotime($selectedMonth)); // Hari pertama bulan ini
    $endDate = date('Y-m-t', strtotime($selectedMonth)); // Hari terakhir bulan ini

    // Query untuk mengambil data siswa dan absensi
    $sql = "SELECT students.id, students.name, students.class, attendance.timestamp 
            FROM students
            LEFT JOIN attendance ON students.unique_id = attendance.user_id 
            AND DATE(attendance.timestamp) BETWEEN :startDate AND :endDate
            WHERE students.class = :class";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':class', $selectedClass);
    $stmt->bindParam(':startDate', $startDate);
    $stmt->bindParam(':endDate', $endDate);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there is attendance data to summarize
    if (count($result) > 0) {
        // Inisialisasi PhpSpreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set properties dokumen
        $spreadsheet->getProperties()->setCreator("Admin")
                                     ->setLastModifiedBy("Admin")
                                     ->setTitle("rekap_absen_" . $selectedClass . ".xls")
                                     ->setSubject("rekap_absen_" . $selectedClass)
                                     ->setDescription("Summary of attendance for class " . $selectedClass)
                                     ->setKeywords("attendance summary, class")
                                     ->setCategory("Summary");

        // Set judul sesuai dengan bulan yang dipilih
        $monthName = date('F Y', strtotime($selectedMonth));
        $sheet->setCellValue('A1', "DATA ABSENSI SISWA BULAN " . $monthName);
        
        // Mengatur format teks judul menjadi bold
        $sheet->getStyle('A1')->getFont()->setBold(true);

        // Mengatur teks judul di tengah
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Set header kolom
        $sheet->setCellValue('A2', 'ID')
              ->setCellValue('B2', 'Name')
              ->setCellValue('C2', 'Class')
              ->setCellValue('D2', 'Role');

        // Menentukan hari kerja dalam satu bulan (Senin-Jumat)
        $workdays = [];
        $currentDate = strtotime($startDate);
        $endDateTimestamp = strtotime($endDate);
        $column = 'E'; // Kolom awal untuk hari kerja

        while ($currentDate <= $endDateTimestamp) {
            $dayOfWeek = date('N', $currentDate);
            if ($dayOfWeek >= 1 && $dayOfWeek <= 5) { // Jika hari Senin-Jumat
                $date = date('Y-m-d', $currentDate);
                $dayNumber = date('d', $currentDate); // Ambil nomor urut tanggal
                $dayName = getDayName($date); // Ambil nama hari dalam bahasa Indonesia
                $sheet->setCellValue($column . '2', $dayNumber);
                $sheet->setCellValue($column . '3', $dayName); // Nama hari di bawah tanggal
                $sheet->getStyle($column . '2')->getAlignment()->setHorizontal('center');
                $sheet->getStyle($column . '3')->getAlignment()->setHorizontal('center')->setWrapText(true);
                $workdays[$date] = $column;
                $column++;
            }
            $currentDate = strtotime('+1 day', $currentDate);
        }

        // Set header untuk total kehadiran dan total absen
        $totalPresentColumn = $column; 
        $totalAbsentColumn = ++$column;

        $sheet->setCellValue($totalPresentColumn . '2', 'Total Present')
              ->setCellValue($totalAbsentColumn . '2', 'Total Absent');
        $sheet->getStyle($totalPresentColumn . '2:' . $totalAbsentColumn . '3')->getAlignment()->setHorizontal('center')->setVertical('center');

        // Gabungkan kolom header ID, Nama, Kelas, dan Role untuk dua baris
        $sheet->mergeCells('A2:A3');
        $sheet->mergeCells('B2:B3');
        $sheet->mergeCells('C2:C3');
        $sheet->mergeCells('D2:D3');
        $sheet->getStyle('A2:D3')->getAlignment()->setHorizontal('center')->setVertical('center');

        // Tulis data ke dalam sheet
        $row = 4;
        foreach ($result as $row_data) {
            $id = $row_data['id'];
            $name = $row_data['name'];
            $class = $row_data['class'];
            $role = 'student';

            $sheet->setCellValue('A'.$row, (string)$id)
                  ->setCellValue('B'.$row, (string)$name)
                  ->setCellValue('C'.$row, (string)$class)
                  ->setCellValue('D'.$row, (string)$role);

            // Inisialisasi total kehadiran dan total absen
            $totalPresent = 0;
            $totalAbsent = 0;

            // Tulis kehadiran berdasarkan kolom hari kerja
            foreach ($workdays as $date => $col) {
                // Tentukan status kehadiran ('H' untuk 'Present' dan '-' untuk 'Absent') berdasarkan data absensi
                $present = '-';
                foreach ($result as $attendance) {
                    if ($attendance['id'] === $row_data['id'] && date('Y-m-d', strtotime($attendance['timestamp'])) === $date) {
                        $present = 'H';
                        break;
                    }
                }
                $sheet->setCellValue($col . $row, $present);

                // Hitung total kehadiran dan total absen
                if ($present === 'H') {
                    $totalPresent++;
                } else {
                    $totalAbsent++;
                }
            }

            // Tulis total kehadiran dan total absen
            $sheet->setCellValue($totalPresentColumn . $row, $totalPresent)
                  ->setCellValue($totalAbsentColumn . $row, $totalAbsent);

            $row++;
        }

        // Set format file Excel
        $sheet->setTitle('rekap_absen_' . $selectedClass);
        $spreadsheet->setActiveSheetIndex(0);

        // Bersihkan buffer output sebelum mengirim header HTTP
        ob_clean();

        // Set header HTTP untuk download file Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="rekap_absen_' . $selectedClass . '.xls"');
        header('Cache-Control: max-age=0');

        // Output file Excel
        $writer = new Xls($spreadsheet);
        $writer->save('php://output');

        exit;
    } else {
        echo "No attendance data to summarize for class $selectedClass in $selectedMonth.";
    }
} else {
    echo "Please select class and month.";
}
?>
