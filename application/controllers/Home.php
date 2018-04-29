<?php

namespace Application\Controllers;

use Application\Core\View;

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

    public function submit($params)
    {
        $view = new View();
        $view->render('home/submit.php');
    }
}