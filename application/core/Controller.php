<?php

namespace Application\Core;

abstract class Controller
{
    protected $route_params = [];

    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    public function __call($name, $arguments)
    {
        $methodToCall = $name;
        if (method_exists($this, $methodToCall)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $methodToCall], $arguments);
                $this->after();
            }
        } else {
            /** @noinspection PhpUnhandledExceptionInspection */
            throw new \Exception("Method $methodToCall not found in controller " . get_class($this));
        }
    }

    public function before()
    { }

    public function after()
    { }
}