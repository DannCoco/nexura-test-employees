<?php 

namespace App\ORM;

use PDO;
use PDOStatement;

interface ModelInterface {
    /**
     * Summary of getPdo
     * @return PDO
     */
    public function getPdo(): PDO;

    /**
     * Summary of lastInsertId
     * @return string
     */
    public function lastInsertId(): string;

    /**
     * Summary of prepare
     * @param string $sql
     * @return PDOStatement
     */
    public function prepare(string $sql) : PDOStatement;

    /**
     * Summary of all
     * @return array
     */
    public function all();

    /**
     * Summary of find
     * @param int $id
     * @return array|null
     */
    public function find(int $id): ?array;

    /**
     * Summary of where
     * @param string $column
     * @param mixed $value
     * @return array
     */
    public function where(string $column, $value): array;

    /**
     * Summary of insert
     * @param array $data
     * @return bool
     */
    public function insert(array $data): bool;

    /**
     * Summary of update
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Summary of delete
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}