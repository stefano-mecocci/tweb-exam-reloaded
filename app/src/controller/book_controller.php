<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/util/alert.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/logged.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/Book.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/Review.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/User.php";

require_once "controller_functions.php";

function getUserFullname($userId) {
    $user = User::getOne($userId);
    $user = prevent_xss($user);

    return $user["first_name"] . " " . $user["last_name"];
}

function formatAvgMark($avgMark) {
    $avgMark = intval($avgMark);

    if ($avgMark == 0) {
        return "Non recensito";
    } else {
        return strval($avgMark) . " stelle su 5";
    }
}

function timestampToDate($t) {
    $x = new DateTime($t);

    return $x->format("d/m/Y");
}

// MAIN - /book/<id:int>

checkIsLogged();
$book = Book::getOne($path[1]);
$reviews = Review::getAllByBook($path[1]);

if ($book == false) {
    $error = "Il libro non esiste";

    require_once($_SERVER['DOCUMENT_ROOT'] . "/view/error_view.php");
    exit();
}

$book = prevent_xss($book);
$reviews = array_map("prevent_xss", $reviews);

require_once($_SERVER['DOCUMENT_ROOT'] . "/view/book_view.php");
