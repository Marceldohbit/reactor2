<?php
include 'db.php';

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$row || !password_verify($password, $row['password'])) {
    respond(['error' => 'Invalid email or password.'], 401);
}

// Start a session and store who logged in
session_start();
session_regenerate_id(true);
$_SESSION['user'] = [
    'id' => $row['id'],
    'name' => $row['name'],
    'email' => $row['email'],
    'role' => $row['role'],
];

// The frontend keeps this token and sends it back to prove it is logged in
respond([
    'message' => 'Welcome ' . $row['name'],
    'token' => session_id(),
    'user' => $_SESSION['user'],
]);
