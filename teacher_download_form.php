<!-- download_teacher_attendance.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Teacher Attendance</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Download Teacher Attendance</h1>
        <form action="download_teacher_attendance.php" method="POST">
            <div class="form-group">
                <label for="month">Pilih Bulan:</label>
                <input type="month" id="month" name="month" required>
            </div>
            <button type="submit" class="btn-blue">Download Excel</button>
        </form>
         <a href="admin.php" class="button-link btn-red">Kembali</a>
    </div>
</body>
</html>
