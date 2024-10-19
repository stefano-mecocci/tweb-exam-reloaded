<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/util/alert.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/logged.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/Order.php";

require_once "controller_functions.php";

function timestampToDate($t) {
  $x = new DateTime($t);

  return $x->format("d/m/Y");
}

// MAIN

checkIsLogged();

$orders = Order::getAllByUser($_SESSION["user"]["id"]);
$orders = array_map("prevent_xss", $orders);

require_once($_SERVER['DOCUMENT_ROOT'] . "/view/orders_view.php");