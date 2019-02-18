<?php

namespace Application\Controllers;

use Application\Core\Router;
use Application\Core\View;
use Application\Models\UserAccount;
use Application\Models\UserAccountModel;
use Application\Models\ViewModels\Account\UserAccountViewModel;
use Application\Utils\HashGenerator;
use DateTime;

class AccountController extends \Application\Core\Controller
{
    public function register()
    {
        $view = new View();
        $view->set('userAccountViewModel', new UserAccountViewModel());
        $view->render('account/register.php');
    }

    public function create($parameters)
    {
        $viewData = array();

        foreach($parameters['userAccountViewModel'] as $parameter)
        {
            if(isset($_POST[$parameter]))
            {
                $viewData[$parameter] = $_POST[$parameter];
            }
        }

        $userAccountViewModel = new UserAccountViewModel($viewData);

        if($userAccountViewModel->isValid())
        {

            $currentTime = date('Y-m-d H:i:s', time());

            $passwordSaltAndHash = HashGenerator::hashString($userAccountViewModel->getPassword());

            $userAccount = new UserAccount();
            $userAccount->setDateCreated($currentTime);
            $userAccount->setUsername($userAccountViewModel->getUsername());
            $userAccount->setEmail($userAccountViewModel->getEmail());
            $userAccount->setPasswordSalt($passwordSaltAndHash['salt']);
            $userAccount->setPasswordHash($passwordSaltAndHash['hash']);

            $createAccount = UserAccountModel::create($userAccount);

            if($createAccount)
            {
               Router::redirect('/home/index');
            }
            else
            {
                echo 'THIS HAS FAILED';
            }

            echo 'xxxxxxxxxxxx';

            echo $createAccount;
        }

            echo 'AAAAA';
            echo $userAccountViewModel->isValid();
            print_r( $userAccountViewModel->validationStatus, 0);
            echo '<br>';
            #$view = new View();
            #$view->set('userAccountViewModel', $userAccountViewModel);
            #$view->render('account/register.php');

        echo '<br>';
        echo '<br>';
            print_r($userAccountViewModel,0);
        echo '<br>';



    }

    public function test($name)
    {

    }
}