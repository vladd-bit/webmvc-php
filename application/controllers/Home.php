<?php

namespace Application\Controllers;

use Application\Config\WebConfig;
use Application\Core\Router;
use Application\Core\View;
use Application\Models\UserAccount;
use Application\Models\UserAccountModel;
use Application\Utils\HashGenerator;

class Home extends \Application\Core\Controller
{
    public function index()
    {
        $view = new View();
        $view->render('home/index.php');
    }

    public function testMethod()
    {
        $view = new View();
        $view->render('home/testMethod.php');
    }

    public function login($parameters)
    {
        $viewData = array();

        foreach($parameters as $parameter)
        {
            if(isset($_POST[$parameter]))
            {
                $viewData[$parameter] = $_POST[$parameter];
            }
            else
            {
                Router::redirect('/home/index');
                die();
            }
        }

        $userAccount = UserAccountModel::getUserByName($viewData['username']);

        if($userAccount)
        {
            $userAccount = new UserAccount($userAccount);

            $sessionKey = HashGenerator::randomizedShaByteHash();

            $userAccount->setSessionKey($sessionKey);
            $userAccount->setLastLogin(date("Y-m-d H:i:s"));

            $updateAccount = UserAccountModel::updateUserSession($userAccount);

            if($updateAccount == false)
            {
                http_response_code(404);
                die();
            }

            session_name('instance');
            session_start();
            $expiryTime = time() + WebConfig::DEFAULT_SESSION_LIFETIME;
            //setcookie('instance', $sessionKey,$expiryTime);
            $_SESSION['userIdentityUsername'] = $userAccount->getUsername();
            $_SESSION['userSessionId'] = $sessionKey;
            $_SESSION['userSessionExpiryTime'] = $expiryTime;

            Router::redirect('/home/dashboard');
            die();
        }

        Router::redirect('/home/index');
        die();

    }

    public function dashboard()
    {
        if(Authentication::isAuthorized())
        {
            $view = new View();
            $view->render('home/dashboard.php');
        }

        Router::redirect('/home/index');
        die();
    }
}