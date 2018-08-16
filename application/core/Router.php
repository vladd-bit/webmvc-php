<?php

namespace Application\Core;

use Application\Config\WebConfig;

class Router
{
    protected $routes = [];

    protected $routeParameters = [];

    public function add($route, $routeParameters = array ())
    {
        $this->routes[$route] = $routeParameters;
    }

    /**
     * matches url to a route in the routing array
     * @param $url
     * @return bool
     */

    private function match($url)
    {
        foreach ($this->routes as $route => $parameters)
        {
            if(strpos($route, $url) !== false)
            {
                $this->routeParameters = $parameters;
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
        $formattedUrl = $url != '' ? $this->removeQueryStringVariables($url) : '/';
        $formattedUrl = self::cleanUrlPath($formattedUrl);

        $isUrlMatching = $this->match($formattedUrl);
        if ($isUrlMatching)
        {
            $controller = $this->getControllerNamespace() . $this->routeParameters['controller'];
            if (class_exists($controller))
            {
                $controllerObject = new $controller($this->routeParameters);

                $action = $this->routeParameters['action'];

                if (method_exists($controllerObject, $action) && is_callable(array($controllerObject, $action)))
                {
                    $parameters = array_key_exists('parameters', $this->routeParameters) ? $this->routeParameters['parameters'] : null ;

                    if($parameters === null)
                    {
                        $controllerObject->$action();
                    }
                    else
                    {
                        $controllerObject->$action($parameters);
                    }
                }
                else
                {
                    Error::log(ErrorLogTypes::webError, new \Exception('Method' . $action . ' in controller ' . $controller . ' cannot be called directly'));
                }
            }
            else
            {
                Error::log(ErrorLogTypes::webError, new \Exception('Controller class  ' . $controller . '  not found'));
            }
        }
        else
        {
            Error::log(ErrorLogTypes::webError, new \Exception('No route :'.$formattedUrl. ' matched.'));
        }
    }

    public static function redirect($route)
    {
        $newUrl = "{$_SERVER['HTTP_HOST']}".WebConfig::WEBSITE_PATH.$route;
        $newUrl = self::cleanUrlPath($newUrl);
        $newUrl = WebConfig::$HTTP_URL_STRING.$newUrl;

        //redirect to new route
        header("HTTP/1.1 302 Found");
        header('location: '.$newUrl);
    }

    protected static function cleanUrlPath($url)
    {
        $newUrl = preg_replace('#/+#','/',$url);
        return $newUrl;
    }

    protected static function removeQueryStringVariables($url)
    {
        $url = strtok($url, "?");
        if ($url != '')
        {
            $parts = explode('&', $url);
            if (strpos($parts[0], '=') === false)
            {
                $url = $parts[0];
            }
            else
            {
                $url = '';
            }
        }
        return $url;
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

