<?php

namespace App\Kernel\Database;

use App\Kernel\Config\ConfigInterface;

class Database implements DatabaseInterface
{
    private \PDO $pdo;

    public function __construct(
        private ConfigInterface $config,
    ) {
        $this->connect();
    }

    public function insert(string $table, array $data): int|false
    {
        $fields = array_keys($data);

        $columns = implode(', ', $fields);
        $bindings = ':' . implode(', :', $fields);

        $sql = "INSERT INTO $table ($columns) VALUES ($bindings)";

        $statement = $this->pdo->prepare($sql);


        try {
            $statement->execute($data);
        } catch (\PDOException $e) {
            return false;
        }

        return $this->pdo->lastInsertId();
    }

    /**
     * Retrieve the first row from the specified table based on the given conditions.
     * Conditions check for equality between all of the columns values and the desired values.
     *
     * $conditions = [ 'column_name' => 'value', ... ]
     *
     * @param  string  $table  The name of the table to query.
     * @param  array  $conditions  An associative array of conditions to filter the query results. The keys represent the column names and the values represent the desired values.
     * @return array|null The first row from the table that matches the conditions, or null if no matching row is found.
     */
    public function first(string $table, array $conditions = []): ?array
    {
        $where = '';
        if (!empty($conditions)) {
            $where = ' WHERE ';
            $where .= implode(' AND ', array_map(fn($key) => "$key = :$key", array_keys($conditions)));
        }

        $sql = "SELECT * FROM $table $where LIMIT 1";

        $statement = $this->pdo->prepare($sql);

        $statement->execute($conditions);

        return $statement->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    public function get(string $table, array $conditions = [], array $order = [], int $limit = -1): array
    {
        $where = '';

        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', array_map(fn($field) => "$field = :$field", array_keys($conditions)));
        }

        $sql = "SELECT * FROM $table $where";

        if (count($order) > 0) {
            $sql .= ' ORDER BY ' . implode(', ', array_map(fn($field, $direction) => "$field $direction", array_keys($order), $order));
        }

        if ($limit > 0) {
            $sql .= " LIMIT $limit";
        }

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($conditions);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function delete(string $table, array $conditions = []): void
    {
        $where = '';

        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', array_map(fn($field) => "$field = :$field", array_keys($conditions)));
        }

        $sql = "DELETE FROM $table $where";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($conditions);
    }

    public function update(string $table, array $data, array $conditions = []): void
    {
        $fields = array_keys($data);

        $set = implode(', ', array_map(fn($field) => "$field = :$field", $fields));

        $where = '';

        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', array_map(fn($field) => "$field = :$field", array_keys($conditions)));
        }

        $sql = "UPDATE $table SET $set $where";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(array_merge($data, $conditions));
    }

    private function connect(): void
    {
        $driver = $this->config->get('database.driver');
        $host = $this->config->get('database.host');
        $port = $this->config->get('database.port');
        $db = $this->config->get('database.db');
        $user = $this->config->get('database.user');
        $password = $this->config->get('database.password');

        $dsn = "$driver:host=$host;port=$port;dbname=$db";

        $this->pdo = new \PDO($dsn, $user, $password);
    }
}
