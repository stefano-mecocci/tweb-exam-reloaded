<?php

namespace App\Controllers;

require_once __DIR__ . "/../core/JsonResponse.php";

use App\Models;
use App\Core\JsonResponse;

$userRepo = new Models\UserRepo();

$ok = $userRepo->save([
    "email" => "mario.rossi@gmail.com",
    "password_hash" => "lfosns93he",
    "first_name" => "Luigi",
    "last_name" => "Verdi",
    "address" => "Via dei Pini 42A",
    "role" => 1,
    "question" => "Come si chiama il tuo gatto?",
    "answer" => "Azzurra"
]);


JsonResponse::sendOk([
    "a" => 2,
]);
