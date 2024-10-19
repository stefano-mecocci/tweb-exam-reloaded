<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/model/Review.php";
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

$rp->addParam("body", "string");
$rp->addParam("mark", "int");
$rp->addParam("bookId", "int");

$rp->addFilters("mark", ["min" => 1, "max" => 5]);
$rp->addFilters("bookId", ["min" => 0]);

$rp->parse();
$params = $rp->getParams();

$review = new Review();

$review->body = $params["body"];
$review->mark = $params["mark"];
$review->bookId = $params["bookId"];

if ($review->save($_SESSION["user"]["id"])) {
    sendResponse("Recensione pubblicata", STATUS_OK);
} else {
    sendResponse("Errore dal server");
}
