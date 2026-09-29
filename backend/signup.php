<?php

include 'db.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? 'admin';

if ($name === '' || $email === '' || $password === '') {
    respond(['error' => 'All fields are required.'], 400);
}
if (!in_array($role, ['admin', 'bursar', 'teacher'])) {
    respond(['error' => 'Invalid role.'], 400);
}

// Check if the email is already used (prepared statement = safe from SQL injection)
$stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
if (mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) {
    respond(['error' => 'An account with that email already exists.'], 409);
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hash, $role);
mysqli_stmt_execute($stmt);

respond(['message' => 'Account created. You can now log in.']);
