<?php

namespace Application\Models;

use Application\Utils\ModelValidator;

class UserAccount extends ModelValidator
{
    private $id;
    private $username;
    private $passwordSalt;
    private $passwordHash;
    private $sessionKey;
    private $email;
    private $failedAttempt;
    private $locked;
    private $lastLogin;
    private $accessLevel;
    private $dateCreated;
    private $dateUpdated;

    public function __construct(Array $properties = array())
    {
        foreach($properties as $key => $value)
        {
            $this->{$key} = $value;
        }


    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPasswordSalt()
    {
        return $this->passwordSalt;
    }

    /**
     * @param mixed $passwordSalt
     */
    public function setPasswordSalt($passwordSalt): void
    {
        $this->passwordSalt = $passwordSalt;
    }

    /**
     * @return mixed
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * @param mixed $passwordHash
     */
    public function setPasswordHash($passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    /**
     * @return mixed
     */
    public function getSessionKey()
    {
        return $this->sessionKey;
    }

    /**
     * @param mixed $sessionKey
     */
    public function setSessionKey($sessionKey): void
    {
        $this->sessionKey = $sessionKey;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFailedAttempt()
    {
        return $this->failedAttempt;
    }

    /**
     * @param mixed $failedAttempt
     */
    public function setFailedAttempt($failedAttempt): void
    {
        $this->failedAttempt = $failedAttempt;
    }

    /**
     * @return mixed
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * @param mixed $locked
     */
    public function setLocked($locked): void
    {
        $this->locked = $locked;
    }

    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param mixed $lastLogin
     */
    public function setLastLogin($lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @return mixed
     */
    public function getAccessLevel()
    {
        return $this->accessLevel;
    }

    /**
     * @param mixed $accessLevel
     */
    public function setAccessLevel($accessLevel): void
    {
        $this->accessLevel = $accessLevel;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param mixed $dateCreated
     */
    public function setDateCreated($dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return mixed
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * @param mixed $dateUpdated
     */
    public function setDateUpdated($dateUpdated): void
    {
        $this->dateUpdated = $dateUpdated;
    }

    public function isValidTest()
    {
        if($this->id === null || $this->id == 0)
        {
            return false;
        }

        if($this->username != null && strlen($this->username) > 40 )
        {
            return false;
        }

        if($this->passwordSalt === null)
        {
            return false;
        }

        if($this->passwordHash === null)
        {
            return false;
        }

        if($this->sessionKey === null)
        {
            return false;
        }

        if($this->email=== null || strlen($this->email) > 255)
        {
            return false;
        }

        if($this->failedAttempt === null)
        {
            return false;
        }

        if($this->locked === null)
        {
            return false;
        }

        if($this->lastLogin === null)
        {
            return false;
        }

        if($this->accessLevel === null)
        {
            return false;
        }

        if($this->dateCreated === null)
        {
            return false;
        }

        if($this->dateUpdated === null)
        {
            return false;
        }
        return true;
    }
}