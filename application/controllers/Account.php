<?php

namespace Application\Controllers;

use Application\Config\WebConfig;
use Application\Core\Controller;
use Application\Core\Handlers\Error\ErrorDatabaseQueryType;
use Application\Core\Handlers\Request\Request;
use Application\Core\Router;
use Application\Core\View;
use Application\Models\UserAccount;
use Application\Models\UserAccountModel;
use Application\Models\ViewModels\UserAccountViewModel;
use Application\Utils\HashGenerator;

class AccountController extends Controller
{
    public function register()
    {
        $view = new View();

        $userAccountViewModel = new UserAccountViewModel();

        $view->set('userAccountViewModel', $userAccountViewModel);
        $view->render('/account/register.php');
    }

    public function create()
    {
        $viewData = Request::getData($this->getRequestParameters());

        $userAccountViewModel = new UserAccountViewModel();
        $userAccountViewModel->setFieldData($viewData);

        if($userAccountViewModel->isValid())
        {
            $currentTime = date(WebConfig::DEFAULT_DATETIME_FORMAT);

            $passwordSaltAndHash = HashGenerator::hashString($userAccountViewModel->password);

            $userAccount = new UserAccount();
            $userAccount->setDateCreated($currentTime);
            $userAccount->setUsername($userAccountViewModel->username);
            $userAccount->setEmail($userAccountViewModel->email);
            $userAccount->setPasswordSalt($passwordSaltAndHash['salt']);
            $userAccount->setPasswordHash($passwordSaltAndHash['hash']);

            $createAccount = UserAccountModel::create($userAccount);

            if($createAccount == ErrorDatabaseQueryType::SuccessfulExecution)
            {
                Router::redirect('/home/index');
            }
            else if($createAccount == ErrorDatabaseQueryType::DuplicateEntry)
            {
                $view = new View();
                $view->set('userAccountViewModel', $userAccountViewModel);
                $view->set('accountExistsError', ErrorDatabaseQueryType::DuplicateEntry);
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
}