<?php

namespace App\Core;

class JsonResponse
{
    public static function sendOk(array $data)
    {
        header('Content-Type: application/json');

        $res = [
            "ok" => true,
            "data" => $data,
        ];

        echo json_encode($res);
    }

    public static function sendError(string $reason)
    {
        header('Content-Type: application/json');

        $res = [
            "ok" => false,
            "reason" => $reason
        ];

        echo json_encode($res);
    }
}