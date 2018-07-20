<?php

try
{
    require_once dirname(__DIR__).'/vendor/autoload.php';

    define('WEBSITE_PATH', \Application\Config\WebConfig::WEBSITE_PATH);
    define('LOGS_FOLDER', dirname(__DIR__).'/logs');
    define('APPLICATION_FOLDER', dirname(__DIR__).'/application');
    define('CONFIG_FOLDER', APPLICATION_FOLDER. '/config');
    define('VIEWS_FOLDER', APPLICATION_FOLDER. '/views');
    define('VENDOR_FOLDER',dirname(__DIR__). '/vendor');
    define('PUBLIC_FOLDER_URL', \Application\Config\WebConfig::$HTTP_URL_STRING.$_SERVER['HTTP_HOST'].\Application\Config\WebConfig::WEBSITE_PATH.'/'.'public');
}
catch(Exception $exception)
{
   throw new \Exception(404);
}

$router = new \Application\Core\Router();

$router->add('/home/index',['controller'=>'Home', 'action' => 'index']);
$router->add('/home/login',['controller'=>'Home', 'action' => 'login', 'parameters' => ['username', 'password'] ]);
$router->add('/home/dashboard',['controller'=>'Home', 'action' => 'dashboard', 'parameters' => ['username'] ]);

$router->dispatch($_SERVER['QUERY_STRING']);

