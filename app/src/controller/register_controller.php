<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/util/alert.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/logged.php";

// MAIN

require_once($_SERVER['DOCUMENT_ROOT'] . "/view/register_view.php");
