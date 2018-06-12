<?php

namespace Application\Controllers;

use Application\Core\View;
use Application\Models;
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
                //invalid model state, return;
                $this->index();
            }
        }

        $user = Models\UserAccountModel::getUser($viewData['username']);

        $test1 = HashGenerator::hashString($viewData['password']);

        print_r($test1, 0);
        return 0;

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