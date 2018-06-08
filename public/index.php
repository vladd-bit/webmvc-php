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


$router->add('/',['controller'=>'Home', 'action' => 'index']);
$router->add('/home/testMethod', ['controller' => 'Home', 'action' => 'testMethod']);
$router->add('/home/submit',['controller'=>'Home', 'action' => 'submit', 'parameters' => ['username', 'password'] ]);

$router->dispatch($_SERVER['QUERY_STRING']);

