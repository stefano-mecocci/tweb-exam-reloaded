<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/model/Cart.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/logged.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/json.php";

if (!isLogged()) {
    exit();
}

if (Cart::moveAllToOrders($_SESSION["user"]["id"])) {
    sendResponse("Pagamento effettuato", STATUS_OK);
} else {
    sendResponse("Errore dal server");
}

