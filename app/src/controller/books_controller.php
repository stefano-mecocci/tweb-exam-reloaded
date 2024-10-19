<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/util/alert.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/logged.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/Book.php";

require_once "controller_functions.php";

// MAIN

checkIsSeller();

$books = Book::getAllBySeller($_SESSION["user"]["id"]);
$books = array_map("prevent_xss", $books);

require_once($_SERVER['DOCUMENT_ROOT'] . "/view/books_view.php");