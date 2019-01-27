<?php

namespace Application\Core;

class View
{
    protected $viewFile;
    protected $viewData = array();

    /**
     * @param $viewFileName    // the name of the view file (php, html etc)
     * @param array $args  // OPTIONAL : the data of the view , a model, a list, variable etc, the VIEW DATA.
     * @throws \Exception
     */
    public function render($viewFileName, $args = array())
    {
        if(!empty($args))
        {
            $this->viewData = $args;
        }

        $this->viewFile = dirname(__DIR__) . \Application\Config\WebConfig::VIEWS_DIRECTORY . $viewFileName;

        if (is_readable($this->viewFile))
        {
            $viewHtml = file_get_contents($this->viewFile);

            $templateDirectives = ['layout.=','title.=', 'partial.=','viewData.='];

            $searchPattern = '/\s.*\$(' .implode('|', $templateDirectives).').*;/';

            /**
             * matches directives in the file and returns an array
             */
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
                 * remove single quotes from the directive value if present e.g $title = 'cool title' , $separatedDirectives[0] will be 'title'
                 * the if statement checks if the line is commented (contains '/'), in that case it ignores it completely.
                 */

                if(strstr($separatedDirectives[0],'/') == false)
                {
                    $templateComponents[$separatedDirectives[0]] = preg_replace('/\'/', '', $separatedDirectives[1]);
                }
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

                    $pageContent = str_replace('{renderBody}', $viewContents, $layoutContents);

                    echo $pageContent;

                }
                else
                {
                    Error::log(ErrorLogType::webError, new \Exception($templateComponents['layout'].' file not found.'));
                }
            }
            else
            {
                if (!empty($this->viewFile))
                {
                    if (is_readable($this->viewFile))
                    {
                        require($this->viewFile);
                    }
                }
            }
        }
        else
        {
            Error::log(ErrorLogType::webError, new \Exception($this->viewFile . ' not found'));
        }
    }

    public function set($key, $value)
    {
        $this->viewData[$key] = $value;
    }
}
