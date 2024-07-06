<?php
include 'config.php';
require 'PHPExcel/PHPExcel.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = ['xls', 'xlsx'];
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $objPHPExcel = PHPExcel_IOFactory::load($fileTmpPath);
            $sheet = $objPHPExcel->getActiveSheet();
            
            // Get all rows from the worksheet
            $data = $sheet->toArray(null, true, true, true);

            // Remove the first row (headers)
            unset($data[1]); // Assuming headers are in row 1, adjust if necessary

            foreach ($data as $row) {
                $name = $row['A'];
                $unique_id = $row['B'];
                $chat_id = $row['C'];

                // Insert data into the database
                $stmt = $pdo->prepare("INSERT INTO students (name, unique_id, chat_id) VALUES (?, ?, ?)");
                $stmt->execute([$name, $unique_id, $chat_id]);
            }
            $message = "File successfully uploaded and data imported.";
        } else {
            $message = "Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions);
        }
    } else {
        $message = "There was an error uploading the file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Data Siswa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Upload Data Siswa</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="file">Format excel harus .xlsx atau .xls</label>
            <input type="file" name="file" id="file" accept=".xlsx, .xls" required>
            <button type="submit" class="btn-blue">Upload</button>
        </form>
        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <a href="admin.php" class="button-link btn-blue">Back to Admin</a>
    </div>
</body>
</html>
