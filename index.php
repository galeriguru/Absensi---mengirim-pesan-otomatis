<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi</title>
    <style>
        /* Tempatkan CSS di sini */
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('admin.jpg'); /* Ubah sesuai dengan nama dan lokasi gambar latar belakang */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 800px;
            text-align: center;
        }
        
        h1 {
            margin-bottom: 20px;
            color: #2980b9;
            font-size: 2.5rem;
        }
        
        .button-container {
            margin-top: 20px;
        }
        
        .button-link {
            padding: 12px 24px;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            background-color: #007BFF;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 0 10px;
        }
        
        .button-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Select Your Role</h1>
        <div class="button-container">
            <a href="user.php" class="button-link">Student</a>
            <a href="user.php" class="button-link">Teacher</a>
            <a href="login.php" class="button-link">Admin</a>
        </div>
    </div>
</body>
</html>
