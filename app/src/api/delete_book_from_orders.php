<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/model/Order.php";
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

$order = new Order();
$order->id = $params["bookId"];

if ($order->delete($_SESSION["user"]["id"])) {
    sendResponse("Libro rimosso correttamente", STATUS_OK);
} else {
    sendResponse("Errore dal server");
}
