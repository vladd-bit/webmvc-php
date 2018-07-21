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
        if(Authentication::isAuthorized())
        {
            Router::redirect('/home/dashboard');
        }
        $view = new View();
        $view->render('home/index.php');
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
            }
        }

        $userAccount = UserAccountModel::getUserByName($viewData['username']);

        if($userAccount)
        {
            $userAccount = new UserAccount($userAccount);

            $sessionKey = HashGenerator::randomizedShaByteHash();

            $validPassword = HashGenerator::validateHash(base64_decode($userAccount->getPasswordSalt()),
                                                         $viewData['password'],
                                                         base64_decode($userAccount->getPasswordHash()));

            if($validPassword)
            {
                $userAccount->setSessionKey($sessionKey);
                $userAccount->setLastLogin(date("Y-m-d H:i:s"));

                $updateAccount = UserAccountModel::updateUserSession($userAccount);

                if($updateAccount == false)
                {
                    http_response_code(404);
                }

                $expiryTime = time() + WebConfig::DEFAULT_SESSION_LIFETIME;

                $_SESSION['identityUsername'] = $userAccount->getUsername();
                $_SESSION['identityEmail'] = $userAccount->getEmail();
                $_SESSION['userSessionId'] = $sessionKey;
                $_SESSION['userSessionExpiryTime'] = $expiryTime;

                Router::redirect('/home/dashboard');
            }
        }

        #Router::redirect('/home/index');
    }

    public function dashboard()
    {
        if(Authentication::isAuthorized())
        {
            $view = new View();
            $viewData['username'] = 'lel';
            $view->render('home/dashboard.php', $viewData);
        }
        else
        {
            echo 'auth failed';
        }
    }
}