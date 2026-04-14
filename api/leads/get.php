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

$lead = new Lead($pdo);

$lead->singleLead($_GET['id']);
echo json_encode($lead->singleLead($_GET['id']));
?>