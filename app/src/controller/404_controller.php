<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/util/alert.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/logged.php";

$error = "Error 404: pagina non trovata";

// MAIN

require_once($_SERVER['DOCUMENT_ROOT'] . "/view/error_view.php");
