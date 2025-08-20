<?php

use Slim\App;
use App\Controller\SaleController;
use App\Repository\SaleRepository;
use App\Repository\SaleDetailRepository;
use App\Repository\SalesHistoryRepository;
use App\Service\SaleService;
use App\Config\Database;
use App\Middleware\JwtMiddleware;
use App\Repository\AuthRepository;
use App\Service\AuthService;

return function (App $app) {
    $db = Database::getConnection();

    $saleRepository = new SaleRepository($db);
    $saleDetailRepository = new SaleDetailRepository($db);
    $salesHistoryRepository = new SalesHistoryRepository($db);

    $saleService = new SaleService($saleRepository, $saleDetailRepository, $salesHistoryRepository);
    $controller = new SaleController($saleService);
     $authRepository = new AuthRepository($db); 
    $authService = new AuthService($authRepository); 
    $jwtMiddleware = new JwtMiddleware($authService);


    
      $app->group('/api/sales', function ($group) use ($controller) {
        $group->get('', [$controller, 'getAll']); 
        $group->get('/{id}', [$controller, 'getById']); 
        $group->post('', [$controller, 'create']);
        $group->put('/{id}', [$controller, 'update']); 
        $group->delete('/{id}', [$controller, 'delete']); 
     })->add(new JwtMiddleware($authService, ['admin', 'kasir'])); 

};
