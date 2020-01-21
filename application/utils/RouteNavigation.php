<?php

namespace Application\Utils;

use Application\Core\Router;

class RouteNavigation
{
    public static function initializeRoutes(Router $router)
    {
        $router->add('/home/index', ['controller'=>'Home', 'action' => 'index']);
        $router->add('/home/logout', ['controller'=>'Home', 'action' => 'logout']);
        $router->add('/home/login', ['controller'=>'Home', 'action' => 'login', 'parameters' => ['username', 'password'] ]);
        $router->add('/home/dashboard', ['controller'=>'Home', 'action' => 'dashboard']);
        $router->add('/account/register', ['controller'=>'Account', 'action' => 'register', 'parameters' => [] ]);
        $router->add('/account/createAccount', ['controller'=>'Account', 'action' => 'create', 'parameters' => ['userAccountViewModel' => []] ]);
    }
}