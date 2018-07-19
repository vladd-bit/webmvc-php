<?php

namespace Application\Controllers;

use Application\Config\WebConfig;
use Application\Core\Model;
use Application\Core\Router;
use Application\Core\View;
use Application\Models;
use Application\Models\UserAccount;
use Application\Utils\HashGenerator;

class Home extends \Application\Core\Controller
{
    /**
     * @return void
     * @throws \Exception
     */
    public function index()
    {
        $view = new View();
        // $view->set('modifyMe', 'HomePage');
        $view->render('home/index.php');
    }

    public function testMethod()
    {
        $view = new View();

        //$testHash = sha1(HashGenerator::randomizedShaByteHash());
        $view->render('home/testMethod.php');
    }

    public function login($parameters)
    {
        $view = new View();
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

        $userAccount = Models\UserAccountModel::getUserByName($viewData['username']);

        if($userAccount != null)
        {
            $userAccount = new UserAccount($userAccount);

            $saltAndHash = HashGenerator::hashString($viewData['password']);

            $sessionKey = HashGenerator::randomizedShaByteHash();
            print_r($saltAndHash, 0);

            $userAccount->setPasswordHash($saltAndHash['hash']);
            $userAccount->setPasswordSalt($saltAndHash['salt']);
            $userAccount->setSessionKey($sessionKey);
            $userAccount->setLastLogin(date("Y-m-d H:i:s"));

            $updateAccount = Models\UserAccountModel::updateUserSession($userAccount);

            if($updateAccount == false)
            {
                http_response_code(404);
                die();
            }

            $expiryTime = time() + WebConfig::DEFAULT_SESSION_LIFETIME;
            setcookie('instance', $sessionKey,$expiryTime);

            $_SESSION['userSessionId'] = $sessionKey;
            $_SESSION['userSessionExpiry'] = $expiryTime;
        }
        else
        {
            Router::redirect('/home/index');
            die();
        }


        // if($user === null)
          // {
        //     echo 'no user found';
        //     $newUserAccount = new UserAccount();

        //     $passwordSaltAndHash = HashGenerator::hashString($viewData['password']);
        //     $sessionKey = HashGenerator::randomizedShaByteHash();

        //     $newUserAccount->setUsername($viewData['username']);
        //     $newUserAccount->setPasswordHash($passwordSaltAndHash['hash']);
        //     $newUserAccount->setPasswordSalt($passwordSaltAndHash['salt']);
        //     $newUserAccount->setSessionKey($sessionKey);

        //     //Models\UserAccountModel::addUser($user);
        // }

        //$view->render('home/submit.php', $viewData);

    }

}