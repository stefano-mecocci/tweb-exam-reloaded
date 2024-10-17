<?php

$host = "db";
$dsn = "mysql:host=$host;port=3306;dbname=appdb";
$user = "app";
$psw = "app99";

$conn = new PDO($dsn, $user, $psw, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

echo "<h1>Connessione riuscita!</h1>";
