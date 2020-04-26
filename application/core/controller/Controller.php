<?php

namespace Application\Core;

abstract class Controller
{
    protected array $route_params = [];

    public function __construct($route_params)
    {
        $this->route_params = $route_params;
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

    public function precall()
    {
    }

    public function aftercall()
    {
    }
}