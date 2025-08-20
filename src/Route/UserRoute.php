<?php
use Slim\App;
use App\Controller\UserController;
use App\Repository\UserRepository;
use App\Service\UserService;
use App\Config\Database;
use App\Middleware\JwtMiddleware;
use App\Repository\AuthRepository;
use App\Service\AuthService;

return function (App $app) {
    $db = Database::getConnection();
    $userRepo = new UserRepository($db);
    $userService = new UserService($userRepo);

     $authRepository = new AuthRepository($db); 
    $authService = new AuthService($authRepository); 
    $jwtMiddleware = new JwtMiddleware($authService);
    $user = new UserController($userService);
    $app->post('/register', [$user, 'register']); 
    $app->get('/users/current', [$user, 'current'])
        ->add(new JwtMiddleware($authService, ['admin','kasir']));
  

};
