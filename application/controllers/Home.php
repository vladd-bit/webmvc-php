<?php

namespace Application\Controllers;

use Application\Config\WebConfig;
use Application\Core\Controller;
use Application\Core\Router;
use Application\Core\View;
use Application\Models\UserAccount;
use Application\Models\UserAccountModel;
use Application\models\viewmodels\home\UserAccountLoginViewModel;
use Application\Models\ViewModels\UserAccountDashboardViewModel;
use Application\Utils\HashGenerator;

class HomeController extends Controller
{
    public function index()
    {
        if(Authentication::isAuthorized())
        {
            Router::redirect('/home/dashboard');
        }

        $userAccountLoginViewModel  = new UserAccountLoginViewModel();

        if(isset($_SESSION["userSessionDataLoginViewModel".session_id()]))
        {
            $userAccountLoginViewModel->setFieldData($_SESSION["userSessionDataLoginViewModel".session_id()]);
        }

        $view = new View();
        $view->set('userAccountLoginViewModel', $userAccountLoginViewModel);
        $view->render('home/index.php');
    }

    public function login(array $parameters)
    {
        if(Authentication::isAuthorized())
        {
            Router::redirect('/home/dashboard');
        }

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

        if(is_array($userAccount))
        {
            $userAccount = new UserAccount($userAccount);

            $sessionKey = HashGenerator::randomizedShaByteHash();

            $validPassword = HashGenerator::validateHash(base64_decode($userAccount->getPasswordSalt()),
                $viewData['password'],
                base64_decode($userAccount->getPasswordHash()));

            if($validPassword)
            {
                $userAccount->setSessionKey($sessionKey);
                $userAccount->setLastLogin(date(WebConfig::DEFAULT_DATETIME_FORMAT));

                $updateAccountSession = UserAccountModel::updateUserSessionLastLogin($userAccount);

                if(!$updateAccountSession)
                {
                    http_response_code(404);
                }

                $expiryTime = time() + WebConfig::DEFAULT_SESSION_LIFETIME;

                $_SESSION['identityUsername'] = $userAccount->getUsername();
                $_SESSION['identityEmail'] = $userAccount->getEmail();
                $_SESSION['userSessionId'] = $sessionKey;
                $_SESSION['userSessionExpiryTime'] = $expiryTime;

                Router::redirect('/dashboard');
            }
        }
        else
        {
            $_SESSION['userSessionDataLoginViewModel'.session_id()] = $viewData;
        }

        Router::redirect('/home/index');
    }

    public function logout()
    {
        $_SESSION['identityUsername'] = null;
        $_SESSION['identityEmail'] = null;
        $_SESSION['userSessionId'] = null;
        $_SESSION['userSessionExpiryTime'] = null;

        Router::redirect('/home/index');
    }

    public function dashboard()
    {
        if(Authentication::isAuthorized())
        {
            $userAccount = new UserAccount(UserAccountModel::getUserByName($_SESSION['identityUsername']));

            if(isset($userAccount))
            {
                $userAccountDashboardViewModel = new UserAccountDashboardViewModel();
                $userAccountDashboardViewModel->username = $userAccount->getUsername();
                $view = new View();
                $view->render('home/dashboard.php', $userAccountDashboardViewModel);
            }
        }
        else
        {
            Router::redirect('/home/index');
        }
    }
}
