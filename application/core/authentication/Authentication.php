<?php

namespace Application\Core\Authentication;

use Application\Models\UserAccountModel;
use Application\Models\UserAccount;

abstract class Authentication implements IAuthentication
{
    public static function isAuthorized(): bool
    {
        if(isset($_SESSION['userSessionId']) && isset($_SESSION['userSessionExpiryTime']))
        {
            $user = new UserAccount(UserAccountModel::getUserBySessionKey($_SESSION['userSessionId']));
            if($user)
            {
                $isLocked = $user->getLocked();
                $sessionExpired = time() > $_SESSION['userSessionExpiryTime'];

                if(!$sessionExpired && $isLocked == 0)
                {
                    return true;
                }
            }
        }

        return false;
    }
}