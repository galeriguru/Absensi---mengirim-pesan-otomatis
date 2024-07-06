<?php
include 'config.php'; // Pastikan config.php berisi konfigurasi database yang benar

try {
    // Buat tabel admins jika belum ada
    $sql = "CREATE TABLE IF NOT EXISTS admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL
    )";
    $pdo->exec($sql);
    echo "Table admins created successfully.<br>";

    // Cek apakah admin default sudah ada
    $username = 'admin';
    $password = md5('password'); // Ganti dengan password yang diinginkan dan hashed dengan MD5

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin) {
        echo "Admin default sudah ada.<br>";
    } else {
        // Tambah admin default
        $stmt = $pdo->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);
        echo "Admin default berhasil ditambahkan.<br>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
