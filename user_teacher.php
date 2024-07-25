<?php
date_default_timezone_set('Asia/Jakarta');
include 'functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = 'teacher';
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
    <title>Absensi Guru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Absensi Guru</h1>
        <form method="post">
            <input type="text" name="unique_id" placeholder="Id Chat" required>
            <button class="btn-blue" type="submit">Kirim Absensi</button>
        </form>
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
