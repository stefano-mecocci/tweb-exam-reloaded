<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/model/Book.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/db.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/json.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/logged.php";
require $_SERVER['DOCUMENT_ROOT'] . "/util/request.php";

// per prevenire errori del file
function checkFileErrors() {
    if (!isset($_FILES["cover"])) {
        sendResponse("Errore del server");
    }

    if (!is_uploaded_file($_FILES["cover"]["tmp_name"])) {
        sendResponse("Errore del server");
    }

    if ($_FILES["cover"]["error"] != UPLOAD_ERR_OK) {
        sendResponse("Caricamento file fallito");
    }
}

// controllo estensione del file
function checkFileExt() {
    $ext = pathinfo("/" . $_FILES["cover"]["name"], PATHINFO_EXTENSION);
    $supported_exts = ["jpg", "jpeg"];

    if (!($ext && in_array($ext, $supported_exts))) {
        sendResponse("Estensione file non valida");
    }
}

function addParamsSpecs($rp) {
    $rp->addParam("title");
    $rp->addParam("authors");
    $rp->addParam("price");
    $rp->addParam("description");
    $rp->addParam("pages", "int");
    $rp->addParam("quantity", "int");
    $rp->addParam("genre", "array");

    $rp->addFilters("title", ["regex" => "/^[A-Za-z0-9 ]{3,100}$/"]);
    $rp->addFilters("authors", ["regex" => "/^[A-Za-z, ]{3,100}$/"]);
    $rp->addFilters("price", ["regex" => "/^\d+(,\d\d)?$/"]);
    $rp->addFilters("pages", ["min" => 10, "max" => 4000]);
    $rp->addFilters("quantity", ["min" => 10, "max" => 40000]);
    $rp->addFilters("description", ["max" => 1000]);
}

// MAIN
if (!isLogged()) {
    exit(); 
}

checkFileErrors();
checkFileExt();

$rp = new RequestParser();
$rp->setErrorHandler(function($field) {
    $translations = [
        "title" => "Titolo",
        "price" => "Prezzo",
        "pages" => "Pagine",
        "quantity" => "Quantità",
        "genre" => "Generi",
        "author" => "Autore",
        "description" => "Descrizione"
    ];

    sendResponse(getErrorMsg($translations, $field));
});

addParamsSpecs($rp);

$rp->parse();
$params = $rp->getParams();

$book = new Book();
$book->title = $params["title"];
$book->description = $params["description"];
$book->setPrice($params["price"]);
$book->pages = $params["pages"];
$book->quantity = $params["quantity"];
$book->genres = implode(",", $params["genre"]);
$book->sellerId = $_SESSION["user"]["id"];
$book->authors = $params["authors"];

if ($book->saveToBooks()) {
    $lastBookId = $book->lastBookId();
    $newPath = "../books_covers/cover" . $lastBookId . ".jpg";

    move_uploaded_file($_FILES["cover"]["tmp_name"], $newPath);
    sendResponse("Libro messo in vendita", STATUS_OK, ["id" => $lastBookId]);
} else {
    sendResponse("Al momento il server non funziona");
}
