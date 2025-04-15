<?php
require 'db.php'; // Your existing DB connection

function createUser($pdo, $name, $email, $password, $role)
{
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 1. Insert user
    $stmt = $pdo->prepare("INSERT INTO users (first_name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $hashedPassword, $role]);
    $user_id = $pdo->lastInsertId();

    // 2. Mark as verified
    $verifyStmt = $pdo->prepare("INSERT INTO email_verification_otp (user_id, verified) VALUES (?, 1)");
    $verifyStmt->execute([$user_id]);

    echo "✅ $role created successfully: $email <br>";
}

// Create superadmin
createUser($pdo, 'Superadmin', 'superadmin@adullam.ng', 'SuperSecure123!', 'superadmin');

// Create admin
createUser($pdo, 'AdminUser', 'admin@adullam.ng', 'AdminSecure123!', 'admin');
