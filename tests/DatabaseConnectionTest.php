<?php
namespace Tests;
use PHPUnit\Framework\TestCase;
use App\Database;

class DatabaseConnectionTest extends TestCase
{
    public function testConnection() {
        $pdo = Database::getInstance();
        $this->assertNotNull($pdo);
        $this->assertEquals(1, $pdo->query('SELECT 1')->fetchColumn());
    }
}