<?php
include 'db.php';
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM admin WHERE email='$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row['password'])) {
        $_SESSION['admin_id'] = $row['id'];
        echo "Welcome".  $email;
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No user found with that email.";
}
