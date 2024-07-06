<?php
require_once 'config.php';

// Ambil semua kelas yang ada di tabel students
$sql = "SELECT DISTINCT class FROM students";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Data</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Download Data Absensi</h1>
        <form method="POST" action="download_attendance.php">
            <div class="form-group">
                <label for="class">Pilih Kelas:</label>
                <select id="class" name="class" required>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?= htmlspecialchars($class['class']) ?>"><?= htmlspecialchars($class['class']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="month">Pilih Bulan:</label>
                <input type="month" id="month" name="month" required>
            </div>

            <div class="button-container">
                <button type="submit" class="btn-blue">Download Data Kehadiran</button>
            </div>
        </form>

        <div class="button-container">
            <a href="admin.php" class="button-link btn-red">Kembali</a>
        </div>
    </div>
</body>
</html>
