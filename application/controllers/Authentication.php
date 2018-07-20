<?php

namespace Application\Controllers;

use Application\Models\UserAccountModel;

class Authentication
{
    public static function isAuthorized()
    {
        session_name('instance');
        session_start();
        if(isset($_SESSION['userSessionId']) && isset($_SESSION['userSessionExpiryTime']))
        {
            $test = $_SESSION['userSessionId'];
            echo $test;
            //$user = UserAccountModel::getUserBySessionKey($_SESSION['userSessionId']);
            //if($user)
            //{
            //    $sessionExpired = time() > $_SESSION['userSessionExpiryTime'];

            //    if($sessionExpired == false)
            //    {
            //        return true;
            //    }
            //}
        }

        return true;
    }
}