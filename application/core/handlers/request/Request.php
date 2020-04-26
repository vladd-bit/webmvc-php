<?php

namespace Application\Core\Handlers\Request;

final class Request
{
    public static function getData($parameters): array
    {
        $viewData = array();

        switch($_SERVER['REQUEST_METHOD'])
        {
            case 'POST':
                foreach($parameters as $parameter)
                {
                    if(isset($_POST[$parameter]))
                    {
                        $viewData[$parameter] = $_POST[$parameter];
                    }
                }
                break;
            case 'GET':
                foreach($parameters as $parameter)
                {
                    if(isset($_GET[$parameter]))
                    {
                        $viewData[$parameter] = $_GET[$parameter];
                    }
                }
                break;
            default:
                break;
        }

        return $viewData;
    }
}