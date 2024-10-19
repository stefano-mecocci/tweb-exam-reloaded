<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/model/Book.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/json.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/logged.php";
require $_SERVER['DOCUMENT_ROOT'] . "/util/request.php";

// MAIN
if (!isLogged()) {
    exit(); 
}

$rp = new RequestParser();

$rp->setErrorHandler(function($field) {
    sendResponse("Errore dal server");
});

$rp->addParam("bookId", "int");
$rp->addFilters("bookId", ["min" => 0]);

$rp->parse();
$params = $rp->getParams();

$book = new Book();
$book->sellerId = $_SESSION["user"]["id"];
$book->id = $params["bookId"];

if ($book->deleteFromBooks()) {
    unlink("../books_covers/cover" . $book->id . ".jpg");
    sendResponse("Libro rimosso correttamente", STATUS_OK);
} else {
    sendResponse("Errore dal server");
}
