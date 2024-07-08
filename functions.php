<?php
include 'config.php';

$botToken = "YOUR_BOT_TOKEN_API"; // Ganti dengan token bot anda

function checkAdminLogin($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}

function addTeacher($name, $unique_id, $chat_id) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO teachers (name, unique_id, chat_id) VALUES (?, ?, ?)");
    $stmt->execute([$name, $unique_id, $chat_id]);
}

function addStudent($name, $unique_id, $chat_id) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO students (name, unique_id, chat_id) VALUES (?, ?, ?)");
    $stmt->execute([$name, $unique_id, $chat_id]);
}

function getAllTeachers() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM teachers");
    return $stmt->fetchAll();
}

function getAllStudents() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM students");
    return $stmt->fetchAll();
}

function getAttendance() {
    global $pdo;
    $stmt = $pdo->query("
        SELECT attendance.*, teachers.name AS teacher_name, students.name AS student_name
        FROM attendance
        LEFT JOIN teachers ON attendance.user_id = teachers.unique_id AND attendance.role = 'teacher'
        LEFT JOIN students ON attendance.user_id = students.unique_id AND attendance.role = 'student'
    ");
    return $stmt->fetchAll();
}

function recordAttendance($unique_id, $role) {
    global $pdo;
    global $botToken;

    // Verify unique_id against the database
    if ($role == 'teacher') {
        $stmt = $pdo->prepare("SELECT * FROM teachers WHERE unique_id = ?");
    } else if ($role == 'student') {
        $stmt = $pdo->prepare("SELECT * FROM students WHERE unique_id = ?");
    } else {
        return "Invalid role";
    }
    $stmt->execute([$unique_id]);
    $user = $stmt->fetch();

    if (!$user) {
        // Unique ID not registered
        return "ID Absen tidak terdaftar";
    }

    // Check if the attendance is already recorded today
    $stmt = $pdo->prepare("SELECT * FROM attendance WHERE user_id = ? AND role = ? AND DATE(timestamp) = CURDATE()");
    $stmt->execute([$unique_id, $role]);
    if ($stmt->rowCount() > 0) {
        return "Anda sudah absen hari ini";
    }

    // Record the attendance
    $stmt = $pdo->prepare("INSERT INTO attendance (user_id, role) VALUES (?, ?)");
    $stmt->execute([$unique_id, $role]);

    // Get user details
    $name = $user['name'];
    $chat_id = $user['chat_id'];
    $timestamp = date('Y-m-d H:i:s');

    // Format message
    $message = "Absen Masuk <b>$name</b> tanggal $timestamp <b>HADIR</b> pada kegiatan belajar di Sekolah\nInformasi ini dikirim secara otomatis dari server sekolah\n<b>No Reply</b>";

    // Convert <b> tags to MarkdownV2 bold format
    $message = str_replace('<b>', '*', $message);
    $message = str_replace('</b>', '*', $message);
    
    // Escape special characters for MarkdownV2
    $message = str_replace(['-', '_', '.', '!', '`'], ['\-', '\_', '\.', '\!', '\`'], $message);

    // Send message to Telegram
    sendMessage($chat_id, $message);

    return "Absensi sukses dikirim";
}

function sendMessage($chat_id, $message) {
    global $botToken;
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'MarkdownV2'
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code != 200) {
        $response_data = json_decode($response, true);
        $error_message = $response_data['description'] ?? 'Unknown error';
        error_log("Failed to send message: $error_message");
    }
}

function updateTeacher($teacher_id, $teacher_name, $teacher_chat_id) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE teachers SET name = ?, chat_id = ? WHERE unique_id = ?");
    $stmt->execute([$teacher_name, $teacher_chat_id, $teacher_id]);
}

function updateStudent($student_id, $student_name, $student_chat_id) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE students SET name = ?, chat_id = ? WHERE unique_id = ?");
    $stmt->execute([$student_name, $student_chat_id, $student_id]);
}
?>
