<?php
require __DIR__ . '/../vendor/autoload.php';
use App\Database;
try {
    $pdo = Database::getInstance();
    $pdo->query('SELECT 1');
} catch (Exception $e) {
    echo 'Error de conexión: ' . $e->getMessage();
    exit(1);
}
