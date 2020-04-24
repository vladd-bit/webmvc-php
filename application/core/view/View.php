<?php

namespace Application\Core;

class View
{
    protected string $viewFile;
    protected $viewData = array();

    /**
     * @param $viewFileName    // the name of the view file (php, html etc)
     * @param array $args  // OPTIONAL : the data of the view , a model, a list, variable etc, the VIEW DATA.
     * @throws \Exception // Exception is thrown if view file is not found, returns 404 automatically and logs errors.
     */
    public function render($viewFileName, $args = array())
    {
        $this->viewFile = Util::cleanUrlPath(VIEWS_FOLDER.$viewFileName);

        if(!empty($args))
        {
            $this->viewData = $args;
        }

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
                $layoutFile = Util::cleanUrlPath(VIEWS_FOLDER.$templateComponents['layout']);

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
                    Error::log(ErrorLogType::webError, new \Exception('Layout file:' . $templateComponents['layout'] .' file not found or not readable in path ' . $layoutFile));
                }
            }
            else
            {
                if (!empty($this->viewFile) && is_readable($this->viewFile))
                {
                    require($this->viewFile);
                }
            }
        }
        else
        {
            Error::log(ErrorLogType::webError, new \Exception('View file: ' . $this->viewFile . ' not found or not readable.'));
        }
    }

    public function set($key, $value)
    {
        $this->viewData[$key] = $value;
    }
}
