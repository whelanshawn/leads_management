<?php
session_start();
header('Content-Type: application/json');

include_once "../../config/db.php";
include_once "../../classes/Lead.php";

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['message' => 'Requires login']);
    exit;
}

if ($_SESSION['role'] != 'role1'/* && $_SESSION['role'] != 'role2'*/) {
    http_response_code(403);
    echo json_encode(['message' => 'User role is unable to delete']);
    exit;
}

$lead = new Lead($pdo);
$lead->delete($_GET['id']);

echo json_encode(['message' => 'Lead deleted']);
?>