<?php

try
{
    require_once dirname(__DIR__).'/vendor/autoload.php';

    ini_set('session.name', \Application\Config\WebConfig::SESSION_NAME);

    if(\Application\Config\WebConfig::MODIFY_SESSION_STORAGE_PATH)
    {
        ini_set('session.save_path', dirname($_SERVER['DOCUMENT_ROOT']).\Application\Config\WebConfig::SESSION_STORAGE_PATH);
    }

    session_start();

    define('WEBSITE_PATH', \Application\Config\WebConfig::WEBSITE_PATH);
    define('LOGS_FOLDER', dirname(__DIR__).'/logs');
    define('APPLICATION_FOLDER', dirname(__DIR__).'/application');
    define('CONFIG_FOLDER', APPLICATION_FOLDER. '/config');
    define('VIEWS_FOLDER', APPLICATION_FOLDER. '/views');
    define('VENDOR_FOLDER',dirname(__DIR__). '/vendor');
    define('PUBLIC_FOLDER_URL', \Application\Config\WebConfig::$HTTP_URL_STRING.$_SERVER['HTTP_HOST'].\Application\Config\WebConfig::WEBSITE_PATH.'/'.'public');


    $router = new \Application\Core\Router();
    \Application\Utils\RouteNavigation::initializeRoutes($router);
    $router->dispatch($_SERVER['QUERY_STRING']);
}
catch(Exception $exception)
{
   throw new \Exception(404);
}