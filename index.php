<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); /* Gradient background */
            color: white;
            margin: 0;
            padding: 0;
        }
        .top-bar {
            width: 100%;
            background-color: #2196f3; /* Blue color */
            padding: 10px 0;
            text-align: center;
        }
        .top-bar h1 {
            margin: 0;
            color: white;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        .logo {
            text-align: center;
            margin-bottom: 10px;
        }
        .logo img {
            width: 70px; /* Adjust as needed */
            height: auto;
        }
        .tagline {
            text-align: center;
            margin-bottom: 20px;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            max-width: 800px;
        }
        .grid-item {
            border-radius: 8px;
            text-align: center;
            padding: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .grid-item i {
            font-size: 40px; /* Adjust as needed */
            margin-bottom: 10px;
            transition: color 0.3s;
        }
        .grid-item a {
            display: block;
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }
        .grid-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .grid-item:hover i,
        .grid-item:hover a {
            color: #ffd700; /* Gold color on hover */
        }
        .home { background-color: #f44336; } /* Red */
        .data-guru { background-color: #e91e63; } /* Pink */
        .lms { background-color: #9c27b0; } /* Purple */
        .e-skl { background-color: #673ab7; } /* Deep Purple */
        .cbt { background-color: #3f51b5; } /* Indigo */
        .e-arsip { background-color: #2196f3; } /* Blue */
        .e-absen-guru { background-color: #03a9f4; } /* Light Blue */
        .e-voting { background-color: #00bcd4; } /* Cyan */
        .galery-pkd { background-color: #009688; } /* Teal */
        .berkas { background-color: #4caf50; } /* Green */
        .media-social { background-color: #8bc34a; } /* Light Green */
        .developer { background-color: #cddc39; } /* Lime */
        .footer {
            margin-top: 20px;
            text-align: center;
            background-color: #2d2d44;
            padding: 10px;
            border-radius: 8px;
            width: 100%;
            max-width: 800px;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <div class="logo">
            <img src="logo.png" alt="Logo">
        <h1>SEKOLAH KITA SEMUA</h1>
        </div>
    </div>
    <div class="container">
        
        <div class="tagline">
            <p>Bersama SEKOLAH KITA SEMUA siap berkarya</p>
        </div>
        <div class="grid-container">
            <div class="grid-item home">
                <i class="fas fa-home"></i>
                <a href="login.php">Home</a>
            </div>
            <!-- <div class="grid-item data-guru">
                <i class="fas fa-chalkboard-teacher"></i>
                <a href="data-guru.html">Data Guru</a>
            </div>
            <div class="grid-item lms">
                <i class="fas fa-graduation-cap"></i>
                <a href="lms.html">LMS</a>
            </div>
            <div class="grid-item e-skl">
                <i class="fas fa-file-alt"></i>
                <a href="e-skl.html">E-SKL</a>
            </div>
            <div class="grid-item cbt">
                <i class="fas fa-laptop"></i>
                <a href="cbt.html">CBT</a>
            </div>
            <div class="grid-item e-arsip">
                <i class="fas fa-archive"></i>
                <a href="e-arsip.html">E-Arsip</a>
            </div> -->
            <div class="grid-item e-absen-guru">
                <i class="fas fa-user-check"></i>
                <a href="user.php">E-Absen Siswa</a>
            </div>
            <div class="grid-item e-voting">
                <i class="fas fa-user-check"></i>
                <a href="user_teacher.php">E-Absen Guru</a>
            </div>
            <!-- <div class="grid-item e-voting">
                <i class="fas fa-vote-yea"></i>
                <a href="e-voting.html">E-Voting</a>
            </div> -->
            <!-- <div class="grid-item galery-pkd">
                <i class="fas fa-images"></i>
                <a href="galery-pkd.html">Galery PKD</a>
            </div> -->
            <!-- <div class="grid-item berkas">
                <i class="fas fa-folder"></i>
                <a href="berkas.html">Berkas</a>
            </div>
            <div class="grid-item media-social">
                <i class="fas fa-share-alt"></i>
                <a href="media-social.html">Media Social</a>
            </div>
            <div class="grid-item developer">
                <i class="fas fa-code"></i>
                <a href="developer.html">Developer</a>
            </div> -->
        </div>
        <div class="footer">
            <p>Knowledge Online Assistance for Learning and Assessment</p>
        </div>
    </div>
    <!-- Add Font Awesome Script -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
