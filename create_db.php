<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', 'Abd803123');
    $pdo->exec('CREATE DATABASE IF NOT EXISTS ecommerce_db');
    echo "Database created successfully or already exists.\n";
} catch (PDOException $e) {
    echo "Error creating database: " . $e->getMessage() . "\n";
    exit(1);
}
