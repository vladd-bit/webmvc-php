<?php

namespace Application\Core;

use Application\Core\Handlers\Error\Error;
use Application\Core\Handlers\Error\ErrorLogType;

abstract class Controller
{
    protected array $routeParameters = [];

    public function __construct($routeParameters)
    {
        $this->routeParameters = $routeParameters;
    }

    public function __call($name, $arguments)
    {
        $methodToCall = $name;
        if (method_exists($this, $methodToCall))
        {
            if ($this->precall() !== false)
            {
                call_user_func_array([$this, $methodToCall], $arguments);
                $this->aftercall();
            }
        }
        else
        {
            Error::log(ErrorLogType::webError, new \Exception("Method $methodToCall not found in controller " . get_class($this)));
        }
    }

    public function getRequestParameters():array
    {
        if(isset($this->routeParameters['parameters']))
            return $this->routeParameters['parameters'];

        return array();
    }

    public function precall()
    {
    }

    public function aftercall()
    {
    }
}