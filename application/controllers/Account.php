<?php

namespace Application\Controllers;

use Application\Core\Router;
use Application\Core\View;
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
            Router::redirect('/home/index');
        }

        $view = new View();
        $view->set('userAccountViewModel', $userAccountViewModel);
        $view->render('account/register.php');
    }
}