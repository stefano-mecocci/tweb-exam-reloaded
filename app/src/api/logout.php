<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/util/alert.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/util/common_api.php";

// effettuo il logout
session_unset();
session_destroy();

// ricreo la sessione per l'alert e reindirizzo
session_start();
sendAlert("success", "Logout effettuato");
redirectTo("/login");

?>