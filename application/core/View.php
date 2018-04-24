<?php

namespace Application\Core;

class View
{
    public static function render($viewFileName, $arguments = array ())
    {
        extract($arguments);

        $viewFile = dirname(__DIR__) . \Application\Config\WebConfig::VIEWS_DIRECTORY . $viewFileName;

        if (is_readable($viewFile))
        {
            $templateHtml = file_get_contents($viewFile);

            $templateDirectives = ['layout','title', 'partial'];

            $searchPattern = '/{('.implode('|', $templateDirectives).').*?}/';

            preg_match_all($searchPattern, $templateHtml, $directiveMatches);

            /**
             * delete all occurrences from the file before returning it clean
             */
            $templateHtml = preg_replace($searchPattern, '', $templateHtml);

            $finalDirectives = [];

            foreach($directiveMatches[0] as $directive)
            {
                $tempDirective = preg_replace('/{|}|\'|\\"/', '', $directive);

                /**
                 *  key value pattern after explosion
                 */
                $separatedDirectives =  explode('=', $tempDirective);
                $finalDirectives[$separatedDirectives[0]] = $separatedDirectives[1];
            }



            //require $viewFile;
        }
        else
        {
            throw new \Exception($viewFile . ' not found');
        }
    }

    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;
        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . \Application\Config\WebConfig::VIEWS_DIRECTORY );
            $twig = new \Twig_Environment($loader);
        }
        echo $twig->render($template, $args);
    }
}
