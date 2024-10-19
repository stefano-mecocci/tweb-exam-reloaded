<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/model/User.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/alert.php";
require $_SERVER['DOCUMENT_ROOT'] . "/util/request.php";
require_once $_SERVER['DOCUMENT_ROOT'] .  "/util/common_api.php";

const ANSWER_FILTER = "/^[a-zA-Z]{3,50}$/";
const QUESTIONS = [
    "Qual è il tuo animale preferito?",
    "Qual è il nome di tua nonna?",
    "Qual è il nome della tua città natale?"
];

function generatePsw($len = 8) {
    $alphabet = str_split("abcdefghijklmnopqrstuvwxyz1234567890");
    $randKeys = array_rand($alphabet, $len);
    $newPsw = "";

    for ($i = 0; $i < count($randKeys); $i++) { 
        $newPsw .= $alphabet[$randKeys[$i]];
    }

    return $newPsw;
}

function inQuestions() {
    return [
        "custom" => fn ($v) => in_array($v, QUESTIONS)
    ];
}

function addParamsSpecs($rp) {
    $rp->addParam("email");
    $rp->addParam("question");
    $rp->addParam("answer");

    $rp->addFilters("email", emailFilter());
    $rp->addFilters("question", inQuestions());
    $rp->addFilters("answer", regexFilter(ANSWER_FILTER));
}

// MAIN
$rp = new RequestParser();

$rp->setErrorHandler(function($field) {
    sendAlert("error", "Il campo $field non va bene");
    redirectTo("/reset");
});

addParamsSpecs($rp);

$rp->parse();
$params = $rp->getParams();

$user = User::getOneByEmail($params["email"]);

if ($user && $user["question"] == $params["question"] && $user["answer"] == $params["answer"]) {
    $newPassword = generatePsw();
    $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);

    if (User::updatePassword($user["email"], $passwordHash)) {
        sendAlert("success", "La tua nuova password è: " . $newPassword);
        redirectTo("/login");
    } else {
        sendAlert("error", "Impossibile reimpostare la password");
        redirectTo("/reset");
    }
} else {
    sendAlert("error", "Risposta o domanda sbagliata");
    redirectTo("/reset");
}
