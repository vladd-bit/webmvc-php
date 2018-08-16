<?php

namespace Application\Controllers;

use Application\Models\UserAccountModel;

class Authentication
{
    public static function isAuthorized()
    {
        if(isset($_SESSION['userSessionId']) && isset($_SESSION['userSessionExpiryTime']))
        {
            $user = UserAccountModel::getUserBySessionKey($_SESSION['userSessionId']);
            if($user)
            {
                $sessionExpired = time() > $_SESSION['userSessionExpiryTime'];

                if($sessionExpired == false)
                {
                    return true;
                }
            }
        }

        return false;
    }
}