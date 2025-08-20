<?php

use Slim\App;
use App\Controller\ProductController;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use App\Config\Database;
use App\Middleware\JwtMiddleware;
use App\Repository\AuthRepository;
use App\Service\AuthService;

return function (App $app) {
    $db = Database::getConnection(); 
    $productRepository = new ProductRepository($db);
    $productService = new ProductService($productRepository);
    $controller = new ProductController($productService);

   $authRepository = new AuthRepository($db); 
    $authService = new AuthService($authRepository); 
    $jwtMiddleware = new JwtMiddleware($authService);

    // Group route dengan JWT
    $app->group('/api/products', function ($group) use ($controller) {
        $group->get('/report', [$controller, 'getAll']);
    })->add(new JwtMiddleware($authService, ['admin'])); 

    $app->group('/api/products', function ($group) use ($controller) {
        $group->get('', [$controller, 'getAll']); 
        $group->get('/{id}', [$controller, 'getById']); 
        $group->post('', [$controller, 'create']); 
        $group->put('/{id}', [$controller, 'update']); 
        $group->delete('/{id}', [$controller, 'delete']); 
    })->add(new JwtMiddleware($authService, ['admin', 'kasir'])); 
    
};