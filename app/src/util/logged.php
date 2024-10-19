<?php

require_once $_SERVER['DOCUMENT_ROOT'] .  "/util/common_api.php";

function isLogged() {
    return !!isset($_SESSION["user"]);
}

function checkIsLogged() {
    if (!isLogged()) {
        sendAlert("error", "Non sei loggato");
        redirectTo("/login");
    }
}

function isSeller() {
    return isLogged() && (intval($_SESSION["user"]["role"]) >= 1);
}

// forse in futuro
/* function isAdmin() {
    return isLogged() && (intval($_SESSION["user"]["role"]) >= 2);
} */

function checkIsSeller() {
    if (!isSeller()) {
        sendAlert("error", "Non sei un venditore");
        redirectTo("/login");
    }
}