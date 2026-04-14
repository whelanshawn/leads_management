<?php
session_start();
header('Content-Type: application/json');

include_once "../../config/db.php";
include_once "../../classes/Lead.php";

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['message' => 'Requires user Login']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name'], $data['description'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Lead name and description required']);
    exit;
}

$lead = new Lead($pdo);

$lead->create($data['name'], $data['description'], $_SESSION['user_id']);

echo json_encode(['message' => 'Lead created']);
?>