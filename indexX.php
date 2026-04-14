<?php
//echo 'HelloWorld';

$host = 'localhost';
$port = '5432';
$db = 'leads';
$user = 'postgres';
$pass = 'postgres';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db;", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>