<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/util/alert.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/logged.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/Cart.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/Card.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/User.php";

require_once "controller_functions.php";

// MAIN

checkIsLogged();

$user = null;
$cards = null;

$cartBooks = Cart::getAllByUser($_SESSION["user"]["id"]);
$cartBooks = array_map("prevent_xss", $cartBooks);

if (!empty($cartBooks)) {
    $user = User::getOne($_SESSION["user"]["id"]);
    $user = prevent_xss($user);

    $cards = Card::getAllByUserId($_SESSION["user"]["id"]);
    $cards = array_map("prevent_xss", $cards);

    $total = Cart::getTotal($_SESSION["user"]["id"]);
    $total = $total["total"];
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/view/cart_view.php");