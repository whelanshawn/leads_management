<?php
session_start();
header('Content-Type: application/json');

include_once "../../config/db.php";
include_once "../../classes/User.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email'], $data['password'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Credentials required, email and password']);
    exit;
}

$userClass = new User($pdo);
$user = $userClass->getByEmail($data['email']);

if ($user && password_verify($data['password'], $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];

    echo json_encode(['message' => 'Login successful']);
} else {
    http_response_code(401);
    echo json_encode(['message' => 'Incorrect Credentials']);
}
?>