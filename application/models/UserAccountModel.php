<?php

namespace Application\Models;

use PDO;

class UserAccountModel extends \Application\Core\Model
{

    public static function getUser($username)
    {
        $db = static::getDB();

        $sql  = 'SELECT * FROM UserAccount WHERE username = :username';

        $query = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $query->execute(array(':username' => $username));

        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function addUser(UserAccount $userAccount)
    {
        $sql = 'INSERT INTO UserAccount ';
    }
}