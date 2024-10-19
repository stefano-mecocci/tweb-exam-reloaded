<?php

header('Content-Type: application/json; charset=utf-8');

const STATUS_OK = "ok";
const STATUS_ERR = "err";

// invia la risposta in formato JSON
function sendResponse($reason, $status = STATUS_ERR, $data = null) {
    $response = [
        "status" => $status,
        "reason" => $reason,
        "data" => $data
    ];

    echo json_encode($response);
    exit();
}