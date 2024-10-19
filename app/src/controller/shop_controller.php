<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/util/alert.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/logged.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/Book.php";

require_once "controller_functions.php";

function formatAvgMark($avgMark) {
    $avgMark = intval($avgMark);

    if ($avgMark == 0) {
        return "Non recensito";
    } else {
        return strval($avgMark) . " stelle su 5";
    }
}

// MAIN

checkIsLogged();

$books = Book::getAll();
$books = array_map("prevent_xss", $books);

require_once($_SERVER['DOCUMENT_ROOT'] . "/view/shop_view.php");
