<?php
date_default_timezone_set('Asia/Jakarta');
include 'functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];
    $unique_id = $_POST['unique_id'];
    
    $result = recordAttendance($unique_id, $role);
    
    if ($result == "Absensi sukses dikirim") {
        $message = 'Absensi sukses dikirim';
    } else if ($result == "Anda sudah absen hari ini") {
        $message = 'Anda sudah absen hari ini';
    } else if ($result == "ID Absen tidak terdaftar") {
        $message = 'ID Absen tidak terdaftar';
    } else {
        $message = 'An error occurred: ' . $result;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Absensi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Tambahkan ini untuk membuat halaman responsif -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Absensi</h1>
        <form method="post">
            <select name="role" required>
                <option value="">Select Role</option>
                <option value="teacher">Guru</option>
                <option value="student">Siswa</option>
            </select>
            <input type="text" name="unique_id" placeholder="Unique ID" required>
            <button class="btn-blue" type="submit">Kirim Absensi</button>
        </form>
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
