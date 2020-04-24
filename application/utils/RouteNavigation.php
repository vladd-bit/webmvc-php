<?php

namespace Application\Utils;

use Application\Core\Router;
use Application\Models\ViewModels\UserAccountLoginViewModel;
use Application\Models\ViewModels\UserAccountViewModel;

abstract class RouteNavigation
{
    private static Router $routerInstance;

    public static function initializeRoutes(Router $router)
    {
        self::$routerInstance = $router;

        self::$routerInstance->add('/home/index', ['controller' => 'Home', 'action' => 'index']);
        self::$routerInstance->add('/home/logout', ['controller' => 'Home', 'action' => 'logout']);
        self::$routerInstance->add('/home/login', ['controller' => 'Home', 'action' => 'login', 'parameters' => UserAccountLoginViewModel::getModelFields() ]);
        self::$routerInstance->add('/home/dashboard', ['controller' => 'Home', 'action' => 'dashboard']);
        self::$routerInstance->add('/account/register', ['controller' => 'Account', 'action' => 'register', 'parameters' => []]);
        self::$routerInstance->add('/account/create', ['controller' => 'Account', 'action' => 'create', 'parameters' => UserAccountViewModel::getModelFields() ]);
    }

    /**
     * @return Router
     */
    public static function getRouterInstance(): Router
    {
        return self::$routerInstance;
    }

    /**
     * @param Router $routerInstance
     */
    public static function setRouterInstance(Router $routerInstance): void
    {
        self::$routerInstance = $routerInstance;
    }

}