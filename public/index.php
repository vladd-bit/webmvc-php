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
$router->add('{controller}/{action}');
$router->add('submit',['controller'=>'Home', 'action' => 'submit']);

$router->dispatch('home/index');


