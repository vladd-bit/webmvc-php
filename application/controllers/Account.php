<?php

namespace Application\Controllers;


use Application\Core\View;
use Application\Models\ViewModels\Home\UserAccountViewModel;

class AccountController extends \Application\Core\Controller
{
    public function register()
    {
        $view = new View();
        $view->render('account/register.php', new UserAccountViewModel());
    }

    public function create($parameters)
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

        $view = new View();


        $view->render('account/register.php', new UserAccountViewModel());
    }
}