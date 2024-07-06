<?php
include 'functions.php';

// Memulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Memeriksa apakah form login telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fungsi untuk memeriksa login admin
    $admin = checkAdminLogin($username, $password);

    if ($admin) {
        $_SESSION['admin'] = $admin; // Menyimpan informasi admin ke dalam session
        header("Location: admin.php"); // Redirect ke halaman admin jika login berhasil
        exit();
    } else {
        $_SESSION['error'] = "Invalid username or password"; // Menyimpan pesan error jika login gagal
        header("Location: login.php"); // Redirect kembali ke halaman login
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="login.css"> <!-- Pastikan path ke login.css sudah benar -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center bg-primary text-white">
                        <h3>Admin Login</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['error'])): ?>
                            <p class="text-danger"><?php echo $_SESSION['error']; ?></p>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>
                        <form method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" id="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.container').classList.add('show');
        });
    </script>
</body>
</html>
