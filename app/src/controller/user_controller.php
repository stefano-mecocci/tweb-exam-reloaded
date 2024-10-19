<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/util/alert.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/logged.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/User.php";

require_once "controller_functions.php";

function getUserFullname($user) {
    return $user["first_name"] . " " . $user["last_name"];
}

// MAIN

checkIsLogged();

$user = User::getOne($_SESSION["user"]["id"]);
$user = prevent_xss($user);

require_once($_SERVER['DOCUMENT_ROOT'] . "/view/user_view.php");
