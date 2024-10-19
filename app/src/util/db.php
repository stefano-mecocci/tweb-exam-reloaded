<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/util/common_api.php";

class Db
{
  private string $username = "app";
  private string $password = "app99";
  public $conn;
  public $stmt;

  public function __construct()
  {
    try {
      $this->conn = new PDO("mysql:host=db;dbname=appdb", $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
    } catch (PDOException $e) {
      redirectTo("/error");
    }
  }

  public function prepare($query, $params)
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
    } catch (PDOException $e) {
      redirectTo("/error");
    }
  }

  function fetchAll()
  {
    if ($this->stmt->execute()) {
      return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
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
      return $this->stmt->fetch(PDO::FETCH_ASSOC);
    } else {
      return false;
    }
  }
}

$DB = new Db();