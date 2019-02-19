<?php

namespace Application\Controllers;

use Application\Config\WebConfig;
use Application\Core\DbError;
use Application\Core\Router;
use Application\Core\View;
use Application\Models\UserAccount;
use Application\Models\UserAccountModel;
use Application\Models\ViewModels\Account\UserAccountViewModel;
use Application\Utils\HashGenerator;

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

        if($userAccountViewModel->getPassword() == $userAccountViewModel->getConfirmPassword())
        {
           # $view = new View();
            #$view->set('userAccountViewModel', $userAccountViewModel);
           # $view->set('confirmPasswordError', DbError::DuplicateEntry);
           # $view->render('account/register.php');
        }

        if($userAccountViewModel->isValid())
        {
            $currentTime = date(WebConfig::DEFAULT_DATETIME_FORMAT);

            $passwordSaltAndHash = HashGenerator::hashString($userAccountViewModel->getPassword());

            $userAccount = new UserAccount();
            $userAccount->setDateCreated($currentTime);
            $userAccount->setUsername($userAccountViewModel->getUsername());
            $userAccount->setEmail($userAccountViewModel->getEmail());
            $userAccount->setPasswordSalt($passwordSaltAndHash['salt']);
            $userAccount->setPasswordHash($passwordSaltAndHash['hash']);

            $createAccount = UserAccountModel::create($userAccount);

            if($createAccount == DbError::SuccessfulExecution)
            {
                Router::redirect('/home/index');
            }
            else if($createAccount == DbError::DuplicateEntry)
            {
                $view = new View();
                $view->set('userAccountViewModel', $userAccountViewModel);
                $view->set('accountExistsError', DbError::DuplicateEntry);
                $view->render('account/register.php');
            }
        }
        else
        {
            $view = new View();
            $view->set('userAccountViewModel', $userAccountViewModel);
            $view->render('account/register.php');
        }

    }

    public function test($name)
    {

    }
}