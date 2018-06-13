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
        return  $result;
    }

    public static function addUser(UserAccount $userAccount)
    {
        $userDetails = $userAccount->getUsername().','.$userAccount->getPasswordSalt().','.$userAccount->getPasswordHash().','
                       .$userAccount->getSessionKey().','.$userAccount->getEmail().'.'.$userAccount->getLastLogin().','
                       .$userAccount->getAccessLevel().','.$userAccount->getDateCreated().','.$userAccount->getDateUpdated();
        $sql = "INSERT INTO UserAccount (username, passwordSalt, passwordHash, sessionKey, email,lastLogin, accessLevel, dateCreated, dateUpdated) VALUES($userDetails)";

        $db = static::getDB();

        $statement = $db->execute($sql);
        echo 'success';
    }
}