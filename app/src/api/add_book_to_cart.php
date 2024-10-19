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
$rp->addParam("quantity", "int");
$rp->addFilters("bookId", ["min" => 0]);
$rp->addFilters("quantity", ["min" => 1, "max" => 500]);

$rp->parse();
$params = $rp->getParams();

$book = new Book();
$book->id = $params["bookId"];

if ($book->saveToCart($_SESSION["user"]["id"], $params["quantity"])) {
    if ($params["quantity"] > 1) {
        sendResponse("Libri aggiunti al carrello", STATUS_OK);
    } else {
        sendResponse("Libro aggiunto al carrello", STATUS_OK);
    }
} else {
    sendResponse("Errore dal server");
}
