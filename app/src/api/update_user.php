<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/model/User.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/json.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/logged.php";
require $_SERVER['DOCUMENT_ROOT'] . "/util/request.php";

const PASSWORD_REGEX = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";

function filterPassword()
{
    $result = null;

    if (isset($_POST["password"])) {
        if ($_POST["password"] != "") {
            if (!!preg_match(PASSWORD_REGEX, $_POST["password"])) {
                $result = $_POST["password"];
            }
        } else {
            $result = $_POST["password"];
        }
    }

    return $result;
}

// MAIN
if (!isLogged()) {
    exit();
}

$rp = new RequestParser();

$rp->setErrorHandler(function ($field) {
    sendResponse("Errore dal $field server");
});

$rp->addParam("email", "string");
$rp->addParam("firstName", "string");
$rp->addParam("lastName", "string");
$rp->addParam("address", "string");

$rp->addFilters("firstName", nameFilter());
$rp->addFilters("lastName", nameFilter());
$rp->addFilters("email", emailFilter());

$rp->parse();
$params = $rp->getParams();

$user = new User();
$user->email = $params["email"];
$user->password = filterPassword();
$user->firstName = $params["firstName"];
$user->lastName = $params["lastName"];
$user->address = $params["address"];
$user->id = $_SESSION["user"]["id"];

if ($user->update()) {
    sendResponse("Informazioni aggiornate correttamente", STATUS_OK);
} else {
    sendResponse("Errore dal server");
}
