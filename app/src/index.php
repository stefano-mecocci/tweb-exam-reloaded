<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dsn = "mysql:host={$_ENV["DB_HOST"]};port={$_ENV["DB_PORT"]};dbname={$_ENV['DB_DB']}";
$user = $_ENV["DB_USER"];
$psw = $_ENV["DB_PSW"];

$conn = new PDO($dsn, $user, $psw, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

echo "<h1>Connessione riuscita!</h1>";
