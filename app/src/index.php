<?php

$path = explode("/", $_SERVER["REQUEST_URI"]);
$path = array_map(fn($p) => trim($p), $path);
$path = array_filter($path, fn($p) => $p != "");
$path = array_values($path);

if (count($path) == 0) {
    $path[0] = "login";
}

switch ($path[0]) {
    case 'reset':
        include "controller/reset_controller.php";
        break;

    case 'shop':
        include "controller/shop_controller.php";
        break;

    case 'user':
        include "controller/user_controller.php";
        break;

    case 'login':
        include "controller/login_controller.php";
        break;

    case 'cart':
        include "controller/cart_controller.php";
        break;

    case 'register':
        include "controller/register_controller.php";
        break;

    case 'books':
        include "controller/books_controller.php";
        break;

    case 'book':
        include "controller/book_controller.php";
        break;

    case 'orders':
        include "controller/orders_controller.php";
        break;

    case 'error':
        include "controller/error_controller.php";
        break;

    case 'test':
        include "test.php";
        break;

    default:
        include "controller/404_controller.php";
        break;
}