<?php

namespace Application\Utils;

use Application\Core\Router;

class RouteNavigation
{
    public static function initializeRoutes(Router $router)
    {
        $router->add('/home/index',['controller'=>'Home', 'action' => 'index']);
        $router->add('/home/login',['controller'=>'Home', 'action' => 'login', 'parameters' => ['username', 'password'] ]);
        $router->add('/home/dashboard',['controller'=>'Home', 'action' => 'dashboard', 'parameters' => ['username'] ]);
        $router->add('/account/register', ['controller'=>'Account', 'action' => 'register', 'parameters' => ['userAccountViewModel']]);
    }
}