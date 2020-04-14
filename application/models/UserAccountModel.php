<?php

namespace Application\Models;

use Application\Core\ErrorDatabaseQueryType;
use PDO;

class UserAccountModel extends \Application\Core\Model
{

    public static function getUserByName($username)
    {
        $db = static::getDB();

        $sql  = 'SELECT * FROM UserAccount WHERE username = :username';

        $query = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $query->execute(array(':username' => $username));

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function getUserBySessionKey($sessionKey)
    {
        $db = static::getDB();

        $sql  = 'SELECT * FROM UserAccount WHERE sessionKey = :sessionKey';

        $query = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $query->execute(array(':sessionKey' => $sessionKey));

        return $query->fetch(PDO::FETCH_ASSOC);
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

        $sql = 'INSERT INTO UserAccount (username, passwordSalt, passwordHash, email, dateCreated) VALUES(:username, :passwordSalt, :passwordHash, :email, :dateCreated)';

        $query = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        try
        {
            $query->execute(array(
                ':username' => $userAccount->getUsername(),
                ':passwordSalt' => $userAccount->getPasswordSalt(),
                ':passwordHash' => $userAccount->getPasswordHash(),
                ':email' => $userAccount->getEmail(),
                ':dateCreated' => $userAccount->getDateCreated(),
            ));
        }
        catch(\PDOException $exception)
        {
            if($exception->getCode() == 23000)
            {
                $query = ErrorDatabaseQueryType::DuplicateEntry;
            }
        }

        return $query;
    }
}