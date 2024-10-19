<?php

function sendAlert($type, $message) {
    unset($_SESSION["alert"]);

    $_SESSION["alert"] = "<div class=\"alert alert-$type\">$message</div>";
}

function displayAlert() {
    if (isset($_SESSION["alert"])) {
        $alert = $_SESSION["alert"];

        unset($_SESSION["alert"]);

        return $alert;
    }
}