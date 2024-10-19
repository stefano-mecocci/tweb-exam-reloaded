<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/model/User.php";
require_once $_SERVER['DOCUMENT_ROOT'] .  "/util/alert.php";
require_once $_SERVER['DOCUMENT_ROOT'] .  "/util/logged.php";
require_once $_SERVER['DOCUMENT_ROOT'] .  "/util/request.php";
require_once $_SERVER['DOCUMENT_ROOT'] .  "/util/common_api.php";

if (isLogged()) {
    sendAlert("success", "Eri già loggato");
    redirectTo("/shop");
}

$rp = new RequestParser();

$rp->setErrorHandler(function($field) {
    redirectTo("/login");
});

$rp->addParam("email", "string");
$rp->addParam("password", "string");

$rp->parse();
$params = $rp->getParams();

$user = User::getOneByEmail($params["email"]);

// tento il login
if ($user && password_verify($params["password"], $user["password"])) {
    // salvo i dati utente in sessione
    $_SESSION["user"] = [
        "id" => $user["id"],
        "role" => $user["role"]
    ];

    redirectTo("/shop");
} else {
    sendAlert("error", "Credenziali sbagliate");
    redirectTo("/login");
}