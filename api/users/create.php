<?php
session_start();
header('Content-Type: application/json');

include_once "../../config/db.php";
include_once "../../classes/User.php";

if ($_SESSION['role'] != 'role1') {
    http_response_code(403);
    echo json_encode(['message' => 'Only admin can create users']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$user = new User($pdo);

$user->create(
    $data['name'],
    $data['email'],
    'P@55word',
    $data['role']
);

echo json_encode(['message' => 'User created']);