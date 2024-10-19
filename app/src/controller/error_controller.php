<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/util/alert.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/logged.php";

$error = "Ops, si è verificato un errore";

// MAIN

require_once($_SERVER['DOCUMENT_ROOT'] . "/view/error_view.php");
