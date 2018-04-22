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


$test = new Application\Controllers\Home(['controller' => 'Home', ['action' =>'index']]);

$test->index();