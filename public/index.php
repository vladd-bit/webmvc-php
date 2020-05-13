<?php

try
{
    require_once dirname(__DIR__).'/vendor/autoload.php';

    define('WEBSITE_PATH', \Application\Config\WebConfig::WEBSITE_PATH);
    define('LOGS_FOLDER', dirname(__DIR__).\Application\Config\WebConfig::LOGS_FOLDER_NAME);
    define('APPLICATION_FOLDER', dirname(__DIR__).'/application');
    define('CONFIG_FOLDER', APPLICATION_FOLDER. '/config');
    define('VENDOR_FOLDER',dirname(__DIR__). '/vendor');
    define('VIEWS_FOLDER', APPLICATION_FOLDER. \Application\Config\WebConfig::VIEWS_DIRECTORY);
    define('SESSION_FOLDER',dirname(__DIR__). \Application\Config\WebConfig::SESSION_STORAGE_PATH);
    define('PUBLIC_FOLDER_URL', \Application\Config\WebConfig::$HTTP_URL_STRING.$_SERVER['HTTP_HOST'].\Application\Config\WebConfig::WEBSITE_PATH.'/'.'public');

    /* SESSION FOLDER CREATION */
    ini_set('session.name', \Application\Config\WebConfig::SESSION_NAME);

    if (!file_exists(SESSION_FOLDER))
    {
        mkdir(SESSION_FOLDER, \Application\Config\WebConfig::DEFAULT_FOLDER_CREATION_PERMISSIONS, true);
    }

    if(file_exists(SESSION_FOLDER.\Application\Config\WebConfig::SESSION_NAME))
    {
        $file = fopen(SESSION_FOLDER.\Application\Config\WebConfig::SESSION_NAME, 'a');
        fclose($file);
    }
    else
    {
        $file = fopen(SESSION_FOLDER . \Application\Config\WebConfig::SESSION_NAME, 'w');
        fclose($file);
    }

    if(\Application\Config\WebConfig::MODIFY_SESSION_STORAGE_PATH)
    {
        ini_set('session.save_path', dirname($_SERVER['DOCUMENT_ROOT']).\Application\Config\WebConfig::SESSION_STORAGE_PATH);
    }

    /* Exception handling */
    set_exception_handler(array('\Application\Core\Handlers\Error\ErrorExceptionHandler', "handleException"));

    /* GARBAGE COLLECTION SETTINGS */

    ini_set('session.gc_maxlifetime', 3600);
    ini_set('session.gc_probability', 1);
    session_set_cookie_params(3600);

    session_start();

    date_default_timezone_set(\Application\Config\WebConfig::DEFAULT_TIMEZONE);
    setlocale(LC_ALL, \Application\Config\WebConfig::DEFAULT_LOCALE_CONFIGURATION);

    Application\Utils\RouteNavigation::initializeRoutes(new \Application\Core\Router());
    Application\Utils\RouteNavigation::getRouterInstance()->dispatch($_SERVER['QUERY_STRING']);
}
catch(Exception $exception)
{
   \Application\Core\Handlers\Error\Error::log(0, $exception);
}