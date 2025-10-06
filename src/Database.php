<?php

namespace App;
use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        try {
            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', Config::DB_HOST, Config::DB_NAME, Config::DB_CHAR);           
            $this->pdo = new PDO($dsn, Config::DB_USER, Config::DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo 'Database connection error: ' . htmlspecialchars($e->getMessage());
            exit;
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }
}