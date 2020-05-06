<?php

namespace Application\Controllers;

use Application\Config\WebConfig;
use Application\Core\Authentication\Authentication;
use Application\Core\Controller;
use Application\Core\Handlers\Request\Request;
use Application\Core\Router;
use Application\Core\View;
use Application\Models\UserAccount;
use Application\Models\UserAccountModel;
use Application\models\viewmodels\UserAccountLoginViewModel;
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

        $view = new View();

        $userAccountLoginViewModel  = new UserAccountLoginViewModel();

        $view->set('userAccountLoginViewModel', $userAccountLoginViewModel);
        $view->render('/home/index.php');
    }

    public function login()
    {
        if (Authentication::isAuthorized())
        {
            Router::redirect('/home/dashboard');
        }

        $viewData = Request::getData($this->getRequestParameters());

        $userAccount = new UserAccount(UserAccountModel::getUserByName($viewData['username']));

        if($userAccount->getId())
        {
            $validPassword = HashGenerator::validateHash(base64_decode($userAccount->getPasswordSalt()),
                $viewData['password'],
                $userAccount->getPasswordHash());

             if($validPassword)
             {
                 $sessionKey = HashGenerator::randomizedShaByteHash();
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

                 Router::redirect('/home/dashboard');
             }
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
                $view->set('userAccountDashboardViewModel', $userAccountDashboardViewModel);
                $view->render('home/dashboard.php');
            }
        }
        else
        {
            Router::redirect('/home/index');
        }
    }
}
