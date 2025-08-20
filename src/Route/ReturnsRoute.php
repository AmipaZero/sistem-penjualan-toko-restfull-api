<?php

use Slim\App;
use App\Controller\ReturnsController;
use App\Repository\ReturnsRepository;
use App\Service\ReturnsService;
use App\Config\Database;
use App\Middleware\JwtMiddleware;
use App\Repository\AuthRepository;
use App\Service\AuthService;
return function (App $app) {
    $db = Database::getConnection(); 
    $returnsRepository = new ReturnsRepository($db);
    $returnsService = new ReturnsService($returnsRepository);
    $controller = new ReturnsController($returnsService);

    $authRepository = new AuthRepository($db); 
    $authService = new AuthService($authRepository); 
    $jwtMiddleware = new JwtMiddleware($authService);

    $app->group('/api/returns', function ($group) use ($controller) {
        $group->get('/report', [$controller, 'getAll']);
    })->add(new JwtMiddleware($authService, ['admin'])); 

    $app->group('/api/returns', function ($group) use ($controller) {
        $group->get('', [$controller, 'getAll']);
        $group->get('/{id}', [$controller, 'getById']);
        $group->post('', [$controller, 'create']);
        $group->put('/{id}', [$controller, 'update']);
        $group->delete('/{id}', [$controller, 'delete']);
    })->add(new JwtMiddleware($authService, ['admin', 'kasir'])); 

};
