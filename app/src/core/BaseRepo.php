<?php

namespace App\Core;

class BaseRepo
{
    public \PDO $conn;

    public $stmt;

    public function __construct()
    {
        $dsn = "mysql:host={$_ENV["DB_HOST"]};port={$_ENV["DB_PORT"]};dbname={$_ENV['DB_DB']}";
        $user = $_ENV["DB_USER"];
        $psw = $_ENV["DB_PSW"];

        $this->conn = new \PDO($dsn, $user, $psw, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);
    }

    public function prepare(string $query, array $params)
    {
        $this->stmt = $this->conn->prepare($query);

        $placeholders = array_keys($params);
        $values = array_values($params);

        for ($i = 0; $i < count($values); $i++) {
            $this->stmt->bindParam($placeholders[$i], $values[$i]);
        }
    }

    public function execute()
    {
        try {
            return $this->stmt->execute();
        } catch (\PDOException $e) {
            var_dump($e);
            // header("Location: /error");
        }
    }

    function fetchAll()
    {
        if ($this->stmt->execute()) {
            return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }

    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    public function fetchOne()
    {
        if ($this->stmt->execute()) {
            return $this->stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }
}