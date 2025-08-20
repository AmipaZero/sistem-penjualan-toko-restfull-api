<?php

use Slim\Factory\AppFactory;
// use App\Middleware\JwtMiddleware;
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// var_dump($_ENV['JWT_SECRET']);
// exit;

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

// $auth = new AuthController();
(require __DIR__ . '/../src/Routes.php')($app);
// $app->post('/register', [$auth, 'register']);
// $app->post('/login', [$auth, 'login']);
// $app->delete('/logout', [$auth, 'logout'])->add(new JwtMiddleware());

$app->run();