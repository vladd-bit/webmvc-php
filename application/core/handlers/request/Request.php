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

    public static function createAntiForgeryToken()
    {
        if (empty($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']))
        {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    public static function getAntiForgeryToken()
    {
        if(empty($_SESSION['csrf_token']))
        {
            static::createAntiForgeryToken();
        }

        return $_SESSION['csrf_token'];
    }

    public static function getAntiForgeryTokenHtml()
    {
        if(empty($_SESSION['csrf_token']))
        {
            static::createAntiForgeryToken();
        }

        return '<input type="hidden" name="csrf_token" id="csfr_token" value="' . $_SESSION['csrf_token'] .'">';
    }

    public static function validateAntiForgeryToken(): bool
    {
        $csrf_token = $_SESSION['csrf_token'];
        $postToken = $_POST['csrf_token'];

        if(!empty($csrf_token) && isset($postToken))
        {
            if (hash_equals($csrf_token, $postToken))
            {
                unset($_SESSION['csrf_token']);
                return true;
            }
        }

        return false;
    }
}