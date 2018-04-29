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
        $view->set('title', 'HomePage');
        $view->render('home/index.php');
    }

    public function submit()
    {
        $view = new View();
        $view->render('home/submit.php');
    }
}