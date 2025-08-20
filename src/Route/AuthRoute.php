<?php
use Slim\App;
use App\Controller\AuthController;
use App\Repository\AuthRepository;
use App\Service\AuthService;
use App\Config\Database;
use App\Middleware\JwtMiddleware;

return function (App $app) {
    $db = Database::getConnection();
    $authRepo = new AuthRepository($db);
    $authService = new AuthService($authRepo);
    $jwtMiddleware = new JwtMiddleware($authService);

    $auth = new AuthController($authService);
    $app->post('/login', [$auth, 'login']);
     $app->delete('/logout', [$auth, 'logout'])->add(new JwtMiddleware($authService, ['admin', 'staff'])); 

};
