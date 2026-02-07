<?php

namespace App\Repositories;

use PDO;

abstract class BaseRepository
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = require __DIR__ . '/../../config/database.php';
    }

    protected function select(string $sql, array $params = []): array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function execute(string $sql, array $params = []): bool
    {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    protected function first(string $sql, array $params = []): ?array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: null;
    }

    protected function lastInsertId(): int
    {
        return (int) $this->db->lastInsertId();
    }
}