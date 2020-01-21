<?php

namespace Application\Models\ViewModels;

use Application\Core\BaseViewModel;

class UserAccountViewModel extends BaseViewModel
{
    private $username;
    private $password;
    private $email;
    private $confirmPassword;

    public function __construct($properties)
    {
        if(isset($properties))
            $this->setFieldData($properties);

        $this->setValidatorMessages(array('username' => 'required|maxLength:20|minLength:4',
            'password' => 'required|maxLength:30|minLength:4|upperCharacters:0|lowerCharacters:4',
            'confirmPassword' => 'required|maxLength:30|minLength:4|upperCharacters:0|lowerCharacters:4',
            'email' => 'required|dataType:email'));

        $this->setValidatorProperties(array('username' => [],
                                           'password' => []));
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
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * @param mixed $confirmPassword
     */
    public function setConfirmPassword($confirmPassword): void
    {
        $this->confirmPassword = $confirmPassword;
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }
}
