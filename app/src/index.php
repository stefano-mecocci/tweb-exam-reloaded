<?php

namespace App;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/models/UserRepo.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader);
$router = new \Bramus\Router\Router();

function requireController(string $name)
{
  require __DIR__ . "/controllers/$name.php";
}

$router->get('/register', function () use ($twig) {
  requireController("register.page");
});

$router->get('/user/new', function () use ($twig) {
  requireController("create_user.api");
});

$router->get('/', function () use ($twig) {
  $userRepo = new Models\UserRepo();

  $user = $userRepo->getBy('email', 'mario.rossi@gmail.com');

  echo $twig->render('index.twig', ['user' => $user]);
});

$router->run();
