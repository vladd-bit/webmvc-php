<?php

namespace Application\Controllers;

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
        $view->set('modifyMe', 'HomePage');
        $view->render('home/index.php');
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
                //invalid model state, redirect;
                Router::redirect('home/index');
                die();
            }
        }

        $user = Models\UserAccountModel::getUserByName($viewData['username']);

        if($user === null)
        {
            echo 'no user found';
            $newUserAccount = new UserAccount();

            $passwordSaltAndHash = HashGenerator::hashString($viewData['password']);
            $sessionKey = HashGenerator::randomizedShaByteHash();

            $newUserAccount->setUsername($viewData['username']);
            $newUserAccount->setPasswordHash($passwordSaltAndHash['hash']);
            $newUserAccount->setPasswordSalt($passwordSaltAndHash['salt']);
            $newUserAccount->setSessionKey($sessionKey);

            //Models\UserAccountModel::addUser($user);
        }






       //print_r($test1, 0);
        //return 0;

        //$isPasswordValid = HashGenerator::


        //echo print_r($test,0);

        //$view->render('home/submit.php', $viewData);
    }

    public function testMethod()
    {
        $view = new View();

        $testHash = sha1(HashGenerator::randomizedShaByteHash());

        echo $testHash;
        //$view->render('home/testMethod.php');
    }



}