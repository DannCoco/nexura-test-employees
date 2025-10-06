<?php

namespace App\ORM;
use App\Database;
use PDO;
use PDOStatement;

abstract class BaseModel implements ModelInterface {
    protected string $table;
    protected string $primaryKey = 'id';
    protected PDO $pdo;

    public function __construct() 
    {
        $this->pdo = Database::getInstance();
    }

    public function getPdo(): PDO 
    {
        return $this->pdo;
    }

    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }

    public function prepare(string $sql) : PDOStatement
    {
        return $this->pdo->prepare($sql);
    }

    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id");
        $stmt->execute(['id' => $id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res === false ? null : $res;
    }

    public function where(string $column, $value): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$column} = :value");
        $stmt->execute(['value' => $value]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(array $data): bool
    {
        $columns = array_keys($data);
        $placeholders = array_fill(0, count($columns), '?');
        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $this->table,
            implode(", ", $columns),
            implode(", ", $placeholders)
        );
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(array_values($data));
    }

    public function update(int $id, array $data): bool
    {
        $columns = array_keys($data);
        $setClause = implode(", ", array_map(fn($col) => "$col = ?", $columns));
        $sql = sprintf(
            "UPDATE %s SET %s WHERE %s = ?",
            $this->table,
            $setClause,
            $this->primaryKey
        );
        $stmt = $this->pdo->prepare($sql);
        $values = array_values($data);
        $values[] = $id;
        return $stmt->execute($values);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function attachPivot(string $pivotTable, array $columns, array $values): bool
    {
        $sql = 'INSERT INTO ' . $pivotTable . ' (' . implode(',', $columns) . ') VALUES ';
        $placeholders = [];
        $params = [];
        foreach ($values as $valueSet) {
            $placeholders[] = '(' . implode(',', array_fill(0, count($valueSet), '?')) . ')';
            $params = array_merge($params, array_values($valueSet));
        }
        $sql .= implode(', ', $placeholders);
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}