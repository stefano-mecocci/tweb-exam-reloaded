<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/model/User.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/alert.php";
require $_SERVER['DOCUMENT_ROOT'] . "/util/request.php";
require_once $_SERVER['DOCUMENT_ROOT'] .  "/util/common_api.php";

const PASSWORD_REGEX = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";
const ANSWER_FILTER = "/^[a-zA-Z]{3,50}$/";
const QUESTIONS = [
    "Qual è il tuo animale preferito?",
    "Qual è il nome di tua nonna?",
    "Qual è il nome della tua città natale?"
];

function inQuestions() {
    return [
        "custom" => fn ($v) => in_array($v, QUESTIONS)
    ];
}

function addParamsSpecs($rp) {
    $rp->addParam("email");
    $rp->addParam("password");
    $rp->addParam("firstName");
    $rp->addParam("lastName");
    $rp->addParam("address");
    $rp->addParam("question");
    $rp->addParam("answer");

    $rp->addFilters("password", regexFilter(PASSWORD_REGEX));
    $rp->addFilters("firstName", nameFilter());
    $rp->addFilters("lastName", nameFilter());
    $rp->addFilters("email", emailFilter());
    $rp->addFilters("question", inQuestions());
    $rp->addFilters("answer", regexFilter(ANSWER_FILTER));
}

// MAIN
$rp = new RequestParser();

$rp->setErrorHandler(function($field) {
    sendAlert("error", "Il campo $field non va bene");
    redirectTo("/register");
});

addParamsSpecs($rp);

$rp->parse();
$params = $rp->getParams();

$user = new User();
$user->email = $params["email"];
$user->password = $params["password"];
$user->firstName = $params["firstName"];
$user->lastName = $params["lastName"];
$user->address = $params["address"];
$user->question = $params["question"];
$user->answer = $params["answer"];

if (array_key_exists("isSeller", $_POST)) {
    $user->role = 1;
}

$user->hashPassword();

if ($user->save()) {
    sendAlert("success", "La registrazione è andata bene");
    redirectTo("/login");
} else {
    sendAlert("error", "Registrazione fallita. Probabile doppia email.");
    redirectTo("/register");
}
