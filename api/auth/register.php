<?php
session_start();

header('Content-Type: application/json');

include_once "../../config/db.php";
include_once "../../classes/User.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name'], $data['email'], $data['password'])) {
    http_response_code(400);
    echo json_encode(['message' => 'All fields are required']);
    exit;
}

$userClass = new User($pdo);

$existingUser = $userClass->getByEmail($data['email']);

if ($existingUser) {
    http_response_code(409);
    echo json_encode(['message' => 'Email already exists']);
    exit;
}

$userClass->create(
    $data['name'],
    $data['email'],
    $data['password']
);

echo json_encode(['message' => 'Registration successful']);
?>