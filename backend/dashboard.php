<?php
include 'db.php';

// Resume the session using the token the frontend sent
ini_set('session.use_strict_mode', 1);
$token = $_SERVER['HTTP_X_AUTH_TOKEN'] ?? '';
if (preg_match('/^[a-zA-Z0-9,-]{22,256}$/', $token)) {
    session_id($token);
}
session_start();

if (empty($_SESSION['user'])) {
    respond(['error' => 'Please log in first.'], 401);
}

function count_rows($conn, $table) {
    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM $table");
    return (int) mysqli_fetch_assoc($result)['total'];
}

$semester = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM semesters WHERE is_active = 1 LIMIT 1"));

$students = mysqli_fetch_all(mysqli_query($conn,
    "SELECT s.name, s.matric_no, s.email, l.name AS level
     FROM students s JOIN levels l ON l.id = s.level_id
     ORDER BY s.name"
), MYSQLI_ASSOC);

respond([
    'user' => $_SESSION['user'],
    'semester' => $semester ? $semester['name'] : 'None',
    'counts' => [
        'students' => count_rows($conn, 'students'),
        'teachers' => count_rows($conn, 'teachers'),
        'courses' => count_rows($conn, 'courses'),
    ],
    'students' => $students,
]);
