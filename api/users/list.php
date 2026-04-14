<?php
session_start();
header('Content-Type: application/json');

include_once "../../config/db.php";
include_once "../../classes/User.php";

$user = new User($pdo);

echo json_encode(
    $user->getAll(
        $_GET['page'] ?? 1,
        $_GET['search'] ?? ''
    )
);