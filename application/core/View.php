<?php

namespace Application\Core;

class View
{
    protected $viewFile;
    protected $viewData;

    public function render($viewFileName, $arguments = array ())
    {
        extract($arguments);

        $this->viewFile = dirname(__DIR__) . \Application\Config\WebConfig::VIEWS_DIRECTORY . $viewFileName;

        if (is_readable($this->viewFile))
        {
            $viewHtml = file_get_contents($this->viewFile);

            $templateDirectives = ['layout','title', 'partial'];

            $searchPattern = '/\s.*\$(' .implode('|', $templateDirectives).').*;/';

            preg_match_all($searchPattern, $viewHtml, $directiveMatches);

            /**
             * store template components such as layout name, page title etc
             */
            $templateComponents = [];

            foreach($directiveMatches[0] as $directive)
            {
                // $tempDirective = preg_replace('/{|}|\s/', '', $directive);
                $tempDirective = preg_replace('/{|}|\s|\$|;/', '', $directive);

                /**
                 *  key value pattern after explosion
                 */
                $separatedDirectives =  explode('=', $tempDirective);

                /**
                 * remove single quotes from the directive value if present
                 */
                $templateComponents[$separatedDirectives[0]] = preg_replace('/\'/', '', $separatedDirectives[1]);
            }

            if(array_key_exists('layout', $templateComponents))
            {
                $layoutFile = dirname(__DIR__). \Application\Config\WebConfig::VIEWS_DIRECTORY.$templateComponents['layout'];

                if(is_readable($layoutFile))
                {
                    ob_start();
                    require($layoutFile);
                    $ob = ob_get_clean();
                    echo str_replace('{renderBody}', include($this->viewFile), $ob);
                }
                else
                {
                    throw new \Exception($templateComponents['layout'].' file not found.');
                }
            }
            else
            {
                require($this->viewFile);
            }
        }
        else
        {
            throw new \Exception($this->viewFile . ' not found');
        }
    }

    //public static function renderTemplate($template, $args = [])
    //{
    //    static $twig = null;
    //    if ($twig === null) {
    //        $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . \Application\Config\WebConfig::VIEWS_DIRECTORY );
    //        $twig = new \Twig_Environment($loader);
    //    }
    //    echo $twig->render($template, $args);
    //}
}
