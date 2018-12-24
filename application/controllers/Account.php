<?php

namespace Application\Controllers;

use Application\Core\Router;
use Application\Core\View;
use Application\Models\UserAccountModel;
use Application\Models\ViewModels\Account\UserAccountViewModel;

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

        #print_r($parameters, 0);#
        foreach($parameters['userAccountViewModel'] as $parameter)
        {
            if(isset($_POST[$parameter]))
            {
                $viewData[$parameter] = $_POST[$parameter];
            }
        }


       # print_r($userAccountViewModel->getUsername(), 0);

        #print_r(array(array_keys(UserAccountViewModel::getModelFields())), 0);
//
        //$userAccount = UserAccountModel::getUserByName($viewData['username']);
//

        $userAccountViewModel = new UserAccountViewModel($viewData);
        $userAccountViewModel->isValid();

        $view = new View();
        $view->set('userAccountViewModel', $userAccountViewModel);
        $view->render('account/register.php');
    }
}


/**
    $userAccountViewModel = new UserAccountViewModel();
    $userAccountViewModel->setUsername($userAccount->getUsername());

    if(!$userAccountViewModel->isValid())
    {
        $view = new View();
        $view->render('home/dashboard.php', $userAccountViewModel);
    }
    else
    {
        print_r($userAccountViewModel->validationStatus, 0);
    }
 */