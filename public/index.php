<?php

/**
 * Initialize resources
 */

try
{
    require_once dirname(__DIR__) . '/vendor/autoload.php';
}
catch(Exception $exception)
{
   /** @noinspection PhpUnhandledExceptionInspection */
   throw new \Exception($exception);
}

$router = new \Application\Core\Router();

$router->add('home',['controller'=>'Home', 'action' => 'index', 'parameters' => ['id']]);

$router->add('search',['controller'=>'Search', 'action' => 'testMethod', 'parameters' => ['id','name']]);

$router->dispatch('home/index');


