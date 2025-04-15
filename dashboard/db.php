<?php
// db.php

$host = 'localhost';        // Change to your DB host
$db   = 'adullam';       // Change to your DB name
$user = 'root';             // Change to your DB user
$pass = '';                 // Change to your DB password
$charset = 'utf8mb4';

// PDO Setup
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
