<?php

$host = 'localhost';
$port = '5432';
$dbname = 'leads';
$username = 'postgres';
$password = 'postgres';

try {
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    die("DB Connection failed: " . $error->getMessage());
}


