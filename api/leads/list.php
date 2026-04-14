<?php
session_start();
header('Content-Type: application/json');
include_once "../../config/db.php";
include_once "../../classes/Lead.php";

// intentionally left unprotected to allow "guest view"

$lead = new Lead($pdo);

echo json_encode(
    $lead->getAll(
        $_GET['page'] ?? 1,
        $_GET['name'] ?? '',
        $_GET['date_from'] ?? null,
        $_GET['date_to'] ?? null
    )
);
?>