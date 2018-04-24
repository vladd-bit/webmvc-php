<?php

namespace Application\Core;

use Application\Config\WebConfig;

class Router
{
    protected $routes = [];

    protected $routeParameters = [];

    public function add($route, $routeParameters = array ())
    {
        $route = preg_replace('/\//', '\\/', $route);

        $route = '/' . $route . '/i';
        $this->routes[$route] = $routeParameters;
    }

    /**
     * matches url to a route in the routing array
     */
    public function match($url)
    {
        foreach ($this->routes as $route => $routeParameters)
        {
            if (preg_match($route, $url, $matches))
            {
                foreach ($matches as $key => $match)
                {
                    if (is_string($key))
                    {
                        $routeParameters[$key] = $match;
                    }
                }

                $this->routeParameters = $routeParameters;
                return true;
            }
        }

        return false;
    }

    /**
     * @param $url
     * @throws \Exception
     */
    public function dispatch($url)
    {
        // remove variables from the url using strtok
        $url = strtok($url, '?');

        if ($this->match($url))
        {
            $controller = $this->getControllerNamespace() . $this->routeParameters['controller'];
            if (class_exists($controller))
            {
                $controllerObject = new $controller($this->routeParameters);

                $action = $this->routeParameters['action'];

                if (method_exists($controllerObject, $action))
                {
                    $controllerObject->$action();
                }
                else
                {
                    throw new \Exception('Method' . $action . ' in controller ' . $controller . ' cannot be called directly');
                }
            }
            else
            {
                throw new \Exception('Controller class  ' . $controller . '  not found');
            }
        }
        else
        {
            throw new \Exception('No route matched.', 404);
        }
    }

    private function getControllerNamespace()
    {
        $namespace = WebConfig::CONTROLLER_NAMESPACE;
        if (array_key_exists('namespace', $this->routeParameters))
        {
            $namespace .= $this->routeParameters['namespace'] . '\\';
        }
        return $namespace;
    }

    public function getRouteParameters()
    {
        return $this->routeParameters;
    }

    public function getRoutes()
    {
        return $this->routes;
    }
}