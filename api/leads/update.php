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

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name'], $data['description'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Missing data']);
    exit;
}

$lead = new Lead($pdo);

$lead->update($_GET['id'], $data['name'], $data['description']);

echo json_encode(['message' => 'Lead updated']);