<?php
// Impor file functions.php
include 'functions.php';

// Ambil data kehadiran
$attendance = getAttendance();
$teachers = getAllTeachers();
$students = getAllStudents();

if (isset($_POST['add_teacher'])) {
    $teacher_name = $_POST['teacher_name'];
    $teacher_id = $_POST['teacher_id'];
    $teacher_chat_id = $_POST['teacher_chat_id'];

    // Panggil fungsi addTeacher untuk menambahkan guru baru
    addTeacher($teacher_name, $teacher_id, $teacher_chat_id);

    // Redirect atau refresh halaman agar data terbaru ditampilkan
    header('Location: admin.php'); // Ganti dengan halaman yang sesuai
    exit();
}

if (isset($_POST['add_student'])) {
    $student_name = $_POST['student_name'];
    $student_id = $_POST['student_id'];
    $student_chat_id = $_POST['student_chat_id'];

    // Panggil fungsi addStudent untuk menambahkan siswa baru
    addStudent($student_name, $student_id, $student_chat_id);

    // Redirect atau refresh halaman agar data terbaru ditampilkan
    header('Location: admin.php'); // Ganti dengan halaman yang sesuai
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            background-image: url('admin.jpg'); /* Ganti dengan path gambar yang sesuai */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Sidebar styles */
        .sidebar {
            width: 250px;
            background-color: #2980b9;
            color: #fff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .sidebar.hide {
            transform: translateX(-100%);
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 20px 0;
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            cursor: pointer;
        }

        /* Content styles */
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .content.shrink {
            margin-left: 0;
        }

        /* Menu toggle styles */
        .menu-toggle {
            position: absolute;
            top: 20px;
            left: 260px;
            font-size: 24px;
            cursor: pointer;
            transition: left 0.3s ease;
        }

        .menu-toggle.hide {
            left: 10px;
        }

        /* Section styles */
        .section {
            display: none;
            margin-top: 20px;
        }

        .section.active {
            display: block;
        }

        /* Form and List styles */
        .form-container {
            margin-top: 20px;
        }

        .list-container {
            margin-top: 20px;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Responsive adjustments */
        @media screen and (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                padding: 10px;
                text-align: center;
            }

            .content {
                margin-left: 0;
                padding: 10px;
            }

            .menu-toggle {
                left: 10px;
            }
        }

        .sidebar ul li a {
            color: #000; /* Ubah warna huruf menjadi hitam */
            text-decoration: none;
            font-size: 18px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <h2>Admin Menu</h2>
    <ul>
        <li><a onclick="showSection('dashboard')">Dashboard</a></li>
        <li><a onclick="showSection('teacherSection')">Manage Teachers</a></li>
        <li><a onclick="showSection('studentSection')">Manage Students</a></li>
        <li><a onclick="showSection('attendanceSection')">View Attendance</a></li>
        <li><a href="attendance_form.php">Download Students Attendance</a></li>
        <li><a href="teacher_download_form.php">Download Teacher Attendance</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<div class="content" id="content">
    <div class="menu-toggle" id="menu-toggle">☰</div>

    <div id="dashboard" class="container section active">
        <h1>Welcome to Admin Page</h1>
        <p>This is the admin dashboard where you can manage the application.</p>
    </div>

    <div id="teacherSection" class="container section">
        <div class="upload-container">
            <a href="upload.php" class="button-link">Upload Teachers</a>
            <a href="format.xls" class="button-link">Download Format</a>
        </div>

        <div class="button-container">
            <button class="btn-blue" onclick="showForm('teacherForm')">Add Teacher</button>
            <button class="btn-blue" onclick="showList('teacherList')">View Teachers</button>
        </div>

        <div id="teacherForm" class="form-container hidden">
            <h2>Add Teacher</h2>
            <form method="post">
                <input type="text" name="teacher_name" placeholder="Teacher Name" required>
                <input type="text" name="teacher_id" placeholder="Unique ID" required>
                <input type="text" name="teacher_chat_id" placeholder="Chat ID" required>
                <button class="btn-blue" type="submit" name="add_teacher">Add Teacher</button>
            </form>
        </div>

        <div id="editTeacherForm" class="form-container hidden">
            <h2>Edit Teacher</h2>
            <form method="post">
                <input type="hidden" id="edit_teacher_id" name="edit_teacher_id">
                <input type="text" id="edit_teacher_name" name="edit_teacher_name" placeholder="Teacher Name" required>
                <input type="text" id="edit_teacher_chat_id" name="edit_teacher_chat_id" placeholder="Chat ID" required>
                <button class="btn-blue" type="submit" name="update_teacher">Update Teacher</button>
            </form>
        </div>

        <div id="teacherList" class="list-container hidden">
            <h2>Teachers</h2>
            <div class="table-container">
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Unique ID</th>
                        <th>Chat ID</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($teachers as $teacher): ?>
                        <tr>
                            <td><?php echo $teacher['name']; ?></td>
                            <td><?php echo $teacher['unique_id']; ?></td>
                            <td><?php echo $teacher['chat_id']; ?></td>
                            <td>
                                <button class="btn-blue" onclick="editTeacher('<?php echo $teacher['unique_id']; ?>', '<?php echo $teacher['name']; ?>', '<?php echo $teacher['chat_id']; ?>')">Edit</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

    <div id="studentSection" class="container section">
        <div class="upload-container">
            <a href="upload.php" class="button-link">Upload Students</a>
            <a href="format.xls" class="button-link">Download Format</a>
        </div>

        <div class="button-container">
            <button class="btn-blue" onclick="showForm('studentForm')">Add Student</button>
            <button class="btn-blue" onclick="showList('studentList')">View Students</button>
        </div>

        <div id="studentForm" class="form-container hidden">
            <h2>Add Student</h2>
            <form method="post">
                <input type="text" name="student_name" placeholder="Student Name" required>
                <input type="text" name="student_id" placeholder="Unique ID" required>
                <input type="text" name="student_chat_id" placeholder="Chat ID" required>
                <button class="btn-blue" type="submit" name="add_student">Add Student</button>
            </form>
        </div>

        <div id="editStudentForm" class="form-container hidden">
            <h2>Edit Student</h2>
            <form method="post">
                <input type="hidden" id="edit_student_id" name="edit_student_id">
                <input type="text" id="edit_student_name" name="edit_student_name" placeholder="Student Name" required>
                <input type="text" id="edit_student_chat_id" name="edit_student_chat_id" placeholder="Chat ID" required>
                <button class="btn-blue" type="submit" name="update_student">Update Student</button>
            </form>
        </div>

        <div id="studentList" class="list-container hidden">
            <h2>Students</h2>
            <div class="table-container">
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Unique ID</th>
                        <th>Chat ID</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo $student['name']; ?></td>
                            <td><?php echo $student['unique_id']; ?></td>
                            <td><?php echo $student['chat_id']; ?></td>
                            <td>
                                <button class="btn-blue" onclick="editStudent('<?php echo $student['unique_id']; ?>', '<?php echo $student['name']; ?>', '<?php echo $student['chat_id']; ?>')">Edit</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

    <div id="attendanceSection" class="container section">
        <h2>Attendance</h2>
        <div class="table-container">
            <table>
                <tr>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Unique ID</th>
                    <th>Timestamp</th>
                </tr>
                <?php if (isset($attendance) && is_array($attendance) && count($attendance) > 0): ?>
                    <?php foreach ($attendance as $record): ?>
                        <?php
                        $user_name = '';
                        if ($record['role'] == 'teacher') {
                            foreach ($teachers as $teacher) {
                                if ($teacher['unique_id'] == $record['user_id']) {
                                    $user_name = $teacher['name'];
                                    break;
                                }
                            }
                        } elseif ($record['role'] == 'student') {
                            foreach ($students as $student) {
                                if ($student['unique_id'] == $record['user_id']) {
                                    $user_name = $student['name'];
                                    break;
                                }
                            }
                        }
                        ?>
                        <tr>
                            <td><?php echo $user_name; ?></td>
                            <td><?php echo $record['role']; ?></td>
                            <td><?php echo $record['user_id']; ?></td>
                            <td><?php echo $record['timestamp']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No attendance records found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('menu-toggle').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('hide');
        document.getElementById('content').classList.toggle('shrink');
        this.classList.toggle('hide');
    });

    function showSection(sectionId) {
        document.querySelectorAll('.section').forEach(section => section.classList.remove('active'));
        document.getElementById(sectionId).classList.add('active');
    }

    function showForm(formId) {
        document.querySelectorAll('.form-container').forEach(form => form.classList.add('hidden'));
        document.getElementById(formId).classList.remove('hidden');
    }

    function showList(listId) {
        document.querySelectorAll('.list-container').forEach(list => list.classList.add('hidden'));
        document.getElementById(listId).classList.remove('hidden');
    }

    function editTeacher(id, name, chatId) {
        document.getElementById('edit_teacher_id').value = id;
        document.getElementById('edit_teacher_name').value = name;
        document.getElementById('edit_teacher_chat_id').value = chatId;
        showForm('editTeacherForm');
    }

    function editStudent(id, name, chatId) {
        document.getElementById('edit_student_id').value = id;
        document.getElementById('edit_student_name').value = name;
        document.getElementById('edit_student_chat_id').value = chatId;
        showForm('editStudentForm');
    }
</script>

</body>
</html>
