<?php

use Slim\App;
use App\Controller\CategoryController;
use App\Repository\CategoryRepository;
use App\Service\CategoryService;
use App\Config\Database;
use App\Middleware\JwtMiddleware;
use App\Repository\AuthRepository;
use App\Service\AuthService;
return function (App $app) {
    $db = Database::getConnection(); 
    $categoryRepository = new CategoryRepository($db);
    $categoryService = new CategoryService($categoryRepository);
    $controller = new CategoryController($categoryService);

     $authRepository = new AuthRepository($db); 
    $authService = new AuthService($authRepository); 
    $jwtMiddleware = new JwtMiddleware($authService);
        // Group route /pemesanan dilindungi dengan JWT
    $app->group('/api/categories', function ($group) use ($controller) {
        $group->get('', [$controller, 'getAll']);
        $group->get('/{id}', [$controller, 'getById']);
        $group->post('', [$controller, 'create']);
        $group->put('/{id}', [$controller, 'update']);
        $group->delete('/{id}', [$controller, 'delete']);
    })->add(new JwtMiddleware($authService, ['admin'])); 
};
