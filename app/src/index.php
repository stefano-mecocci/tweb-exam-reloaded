<?php

namespace App;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/models/UserRepo.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader);
$router = new \Bramus\Router\Router();

$router->get('/create', function () use ($twig) {
  $userRepo = new Models\UserRepo();

  $r = $userRepo->save([
    "email" => "mario.rossi@gmail.com",
    "password_hash" => "lfosns93he",
    "first_name" => "Stefano",
    "last_name" => "Mecocci",
    "address" => "Via dei Pini 42A",
    "role" => 1,
    "question" => "Come si chiama il tuo gatto?",
    "answer" => "Azzurra"
  ]);

  echo $twig->render('index', ['query' => $r]);
});

$router->get('/', function () use ($twig) {
  $userRepo = new Models\UserRepo();

  $user = $userRepo->getBy('email', 'mario.rossi@gmail.com');

  echo $twig->render('index.twig', ['user' => $user]);
});

$router->run();
