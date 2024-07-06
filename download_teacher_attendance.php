<?php
require 'vendor/autoload.php'; // Sesuaikan path ini jika perlu

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

// Include file konfigurasi database
require_once 'config.php';

// Fungsi untuk mengubah nama hari menjadi bahasa Indonesia
function getDayName($date) {
    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    $dayOfWeek = date('N', strtotime($date)); // Mendapatkan indeks hari dalam seminggu (1: Senin, ..., 7: Minggu)
    return $days[$dayOfWeek - 1];
}

// Ambil nilai bulan dari formulir
if (isset($_POST['month'])) {
    $selectedMonth = $_POST['month'];

    // Tentukan awal dan akhir bulan berdasarkan bulan yang dipilih
    $startDate = date('Y-m-01', strtotime($selectedMonth)); // Hari pertama bulan ini
    $endDate = date('Y-m-t', strtotime($selectedMonth)); // Hari terakhir bulan ini

    // Query untuk mengambil data absensi guru dari tabel teachers dan attendance
    $sql = "SELECT teachers.id, teachers.name, teachers.unique_id, attendance.role, attendance.timestamp 
            FROM teachers
            INNER JOIN attendance ON teachers.unique_id = attendance.user_id 
            WHERE DATE(attendance.timestamp) BETWEEN :startDate AND :endDate";

    $stmt = $pdo->prepare($sql);
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
                                     ->setTitle("DATA ABSENSI GURU BULAN " . date('F Y', strtotime($selectedMonth)))
                                     ->setSubject("Summary of attendance for teachers for " . date('F Y', strtotime($selectedMonth)))
                                     ->setDescription("Summary of attendance for teachers for the selected month")
                                     ->setKeywords("teacher attendance summary, month")
                                     ->setCategory("Summary");

        // Set header kolom
        $sheet->setCellValue('A1', 'ID')
              ->setCellValue('B1', 'Name')
              ->setCellValue('C1', 'Unique ID')
              ->setCellValue('D1', 'Role');

        // Menentukan hari kerja dalam satu bulan (Senin-Jumat)
        $workdays = [];
        $currentDate = strtotime($startDate);
        $endDateTimestamp = strtotime($endDate);
        $column = 'E'; // Kolom awal untuk hari kerja

        while ($currentDate <= $endDateTimestamp) {
            $dayOfWeek = date('N', $currentDate);
            if ($dayOfWeek >= 1 && $dayOfWeek <= 5) { // Jika hari Senin-Jumat
                $date = date('Y-m-d', $currentDate);
                $dayName = getDayName($date); // Ambil nama hari dalam bahasa Indonesia
                $sheet->setCellValue($column . '1', date('d', $currentDate));
                $sheet->setCellValue($column . '2', $dayName); // Nama hari di bawah tanggal
                $workdays[$date] = $column;
                $column++;
            }
            $currentDate = strtotime('+1 day', $currentDate);
        }

        // Set header untuk total kehadiran dan total absen
        $totalPresentColumn = $column; 
        $totalAbsentColumn = ++$column;

        $sheet->setCellValue($totalPresentColumn . '1', 'Total Present')
              ->setCellValue($totalAbsentColumn . '1', 'Total Absent');

        // Gabungkan kolom header ID, Nama, Unique ID, dan Role untuk dua baris
        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');
        $sheet->mergeCells('C1:C2');
        $sheet->mergeCells('D1:D2');

        // Tulis data ke dalam sheet
        $row = 3;
        foreach ($result as $row_data) {
            $id = $row_data['id'];
            $name = $row_data['name'];
            $uniqueId = $row_data['unique_id'];
            $role = $row_data['role'];

            $sheet->setCellValue('A'.$row, (string)$id)
                  ->setCellValue('B'.$row, (string)$name)
                  ->setCellValue('C'.$row, (string)$uniqueId)
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
        $sheetTitle = 'DATA ABSENSI GURU ' . date('F Y', strtotime($selectedMonth));
        $sheetTitle = substr($sheetTitle, 0, 31); // Batasi judul sheet maksimum 31 karakter
        $sheet->setTitle($sheetTitle);
        $spreadsheet->setActiveSheetIndex(0);

        // Bersihkan buffer output sebelum mengirim header HTTP
        ob_clean();

        // Set header HTTP untuk download file Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="DATA_ABSENSI_GURU_' . date('F_Y', strtotime($selectedMonth)) . '.xls"');
        header('Cache-Control: max-age=0');

        // Output file Excel
        $writer = new Xls($spreadsheet);
        $writer->save('php://output');

        exit;
    } else {
        echo "No attendance data to summarize for the selected month.";
    }
} else {
    echo "Please select a month.";
}
?>
