<?php
session_start();
header('Content-Type: application/json');

include_once "../../config/db.php";
include_once "../../classes/User.php";

if ($_SESSION['role'] != 'role1') {
    http_response_code(403);
    echo json_encode(['message' => 'Only admins can delete users']);
    exit;
}

$user = new User($pdo);
$user->delete($_GET['id']);

echo json_encode(['message' => 'User deleted']);