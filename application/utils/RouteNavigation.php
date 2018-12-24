<?php

namespace Application\Utils;

use Application\Core\Router;
use Application\Models\ViewModels\Account\UserAccountViewModel;

class RouteNavigation
{
    public static function initializeRoutes(Router $router)
    {
        $router->add('/home/index',['controller'=>'Home', 'action' => 'index']);
        $router->add('/home/logout',['controller'=>'Home', 'action' => 'logout']);
        $router->add('/home/login',['controller'=>'Home', 'action' => 'login', 'parameters' => ['username', 'password'] ]);
        $router->add('/home/dashboard',['controller'=>'Home', 'action' => 'dashboard', 'parameters' => ['username'] ]);
        $router->add('/account/register', ['controller'=>'Account', 'action' => 'register', 'parameters' => [] ]);
        $router->add('/account/createAccount', ['controller'=>'Account', 'action' => 'create', 'parameters' => ['userAccountViewModel' => (new UserAccountViewModel())->getModelFields()]]);
    }
}