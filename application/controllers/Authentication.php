<?php

namespace Application\Controllers;

use Application\Models\UserAccountModel;
use Application\Models\UserAccount;

class Authentication
{
    public static function isAuthorized()
    {
        if(isset($_SESSION['userSessionId']) && isset($_SESSION['userSessionExpiryTime']))
        {
            $user = new UserAccount(UserAccountModel::getUserBySessionKey($_SESSION['userSessionId']));
            if($user)
            {
                $isLocked = $user->getLocked();
                $sessionExpired = time() > $_SESSION['userSessionExpiryTime'];

                if($sessionExpired == false && $isLocked == 0)
                {
                    return true;
                }
            }
        }

        return false;
    }
}