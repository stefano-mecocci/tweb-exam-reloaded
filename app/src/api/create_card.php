<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/model/Card.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/json.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/logged.php";
require $_SERVER['DOCUMENT_ROOT'] . "/util/request.php";

if (!isLogged()) {
    exit(); 
}

$rp = new RequestParser();
$rp->setErrorHandler(function($field) {
    $translations = [
        "number" => "numero carta",
        "expiringDate" => "data scadenza"
    ];

    sendResponse(getErrorMsg($translations, $field));
});

$rp->addParam("number", "string");
$rp->addParam("cvv", "string");
$rp->addParam("expiringDate", "string");

$rp->addFilters("number", fixedNumFilter(16));
$rp->addFilters("cvv", fixedNumFilter(3));
$rp->addFilters("expiringDate", ["max" => 12]);

$rp->parse();
$params = $rp->getParams();

$card = new Card();

$card->number = $params["number"];
$card->cvv = $params["cvv"];
$card->expiringDate = $params["expiringDate"];
$card->userId = $_SESSION["user"]["id"];

if ($card->save()) {
    sendResponse("Carta aggiunta correttamente", STATUS_OK);
} else {
    sendResponse("Errore dal server");
}
