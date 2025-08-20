<?php

use Slim\App;

return function (App $app) {
    (require __DIR__ . '/Route/CategoryRoute.php')($app);
    (require __DIR__ . '/Route/ProductRoute.php')($app);
    (require __DIR__ . '/Route/SaleRoutes.php')($app);
    (require __DIR__ . '/Route/ReturnsRoute.php')($app);
    (require __DIR__ . '/Route/UserRoute.php')($app);
    (require __DIR__ . '/Route/AuthRoute.php')($app);
};