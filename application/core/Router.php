<?php

namespace Application\Core;

use Application\Config\WebConfig;

class Router
{
    protected $routes = [];

    protected $routeParameters = [];

    public function add($route, $routeParameters = array ())
    {
        //$route = preg_replace('/\//', '\\/', $route);
        //$route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        //$route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        //$route = '/^' . $route . '/i';
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
        // remove query variables from the url using strtok
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

    public static function redirect($route)
    {
        $newUrl = "{$_SERVER['HTTP_HOST']}".'/'.WebConfig::PROJECT_FOLDER.$route;
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
        if ($url != '') {
            $parts = explode('&', $url, 2);
            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
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

