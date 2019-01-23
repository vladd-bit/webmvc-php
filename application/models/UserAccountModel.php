<?php

namespace Application\Models;

use PDO;

class UserAccountModel extends \Application\Core\Model
{

    public static function getUserByName($username)
    {
        $db = static::getDB();

        $sql  = 'SELECT * FROM UserAccount WHERE username = :username';

        $query = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $query->execute(array(':username' => $username));

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getUserBySessionKey($sessionKey)
    {
        $db = static::getDB();

        $sql  = 'SELECT * FROM UserAccount WHERE sessionKey = :sessionKey';

        $query = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $query->execute(array(':sessionKey' => $sessionKey));

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function updateUserSessionLastLogin(UserAccount $userAccount)
    {
        $db = static::getDB();

        $sql = 'UPDATE UserAccount SET  sessionKey = :sessionKey, lastLogin = :lastLogin';
        $query = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $query->execute(array(
            ':sessionKey' => $userAccount->getSessionKey(),
            ':lastLogin' => $userAccount->getLastLogin()
        ));

        return $query;
    }

    public static function create(UserAccount $userAccount)
    {
        $db = static::getDB();

        $userDetails = $userAccount->getUsername().','.$userAccount->getPasswordSalt().','.$userAccount->getPasswordHash().','
                       .$userAccount->getEmail().','
                       .$userAccount->getAccessLevel().','.$userAccount->getDateCreated().','.$userAccount->getDateUpdated();
        $sql = "INSERT INTO UserAccount (username, passwordSalt, passwordHash, email, accessLevel, dateCreated, dateUpdated) VALUES($userDetails)";

        $result = $db->execute($sql);

        return $result;
    }
}