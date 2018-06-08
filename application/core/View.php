<?php

namespace Application\Core;

class View
{
    protected $viewFile;
    protected $viewData = array();

    /**
     * @param $viewFileName    // the name of the view file (php, html etc)
     * @param array $arguments  // OPTIONAL : the data of the view list, variable etc
     * @throws \Exception
     */
    public function render($viewFileName, $arguments = array())
    {
        if(!empty($arguments))
        {
            $this->viewData = $arguments;
        }

        extract($this->viewData);

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

            /**
             * set the layout and title according to configuration
             */
            if(array_key_exists('title', $templateComponents))
            {
                $title = $templateComponents['title'];
            }

            if(array_key_exists('layout', $templateComponents))
            {
                $layoutFile = dirname(__DIR__). \Application\Config\WebConfig::VIEWS_DIRECTORY.$templateComponents['layout'];

                if(is_readable($layoutFile))
                {
                    ob_start();
                    include($layoutFile);
                    $layoutContents = ob_get_contents();
                    ob_clean();

                    ob_start();
                    include($this->viewFile);
                    $viewContents = ob_get_contents();
                    ob_clean();

                    if(array_key_exists('title', $templateComponents))
                    {
                        $title = $templateComponents['title'];
                    }

                    $pageContent = str_replace('{renderBody}', $viewContents, $layoutContents);

                    echo $pageContent;

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

    public function set($key, $value)
    {
        $this->viewData[$key] = $value;
    }
}
