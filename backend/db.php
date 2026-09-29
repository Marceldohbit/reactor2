<?php

// Allow the frontend (opened from another folder / Live Server) to call this API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token');
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit; // browser "preflight" check, nothing else to do
}

$host = 'localhost';
$user = 'root';
$password = "" ;
$db_name = 'management';

$conn = mysqli_connect($host, $user, $password, $db_name);

if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'Connection failed: ' . mysqli_connect_error()]);
    exit;
}

// Send a JSON answer back to the frontend and stop
function respond($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data);
    exit;
}
