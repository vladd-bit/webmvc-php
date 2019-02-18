<?php

namespace Application\Models\ViewModels\Account;

use Application\Core\BaseViewModel;

class UserAccountViewModel extends BaseViewModel
{
    private $username;
    private $password;
    private $email;
    private $confirmPassword;

    private $validationProperties = array('username' => 'required|maxLength:20|minLength:4',
                                          'password' => 'required|maxLength:30|minLength:4|upperCharacters:0|lowerCharacters:4',
                                          'email' => 'required|dataType:email');

    private $validationMessages   = array('username' => ['maxLength' =>'the password must be at least 4 characters', 'success' => 'great success','error' =>'this is a custom error message'],
                                          'password' => ['maxLength' =>'the password must be at least 4 characters', 'success' => 'great success','error' =>'this is a custom error message']
                                          );

    /**
     * UserAccountViewModel constructor.
     * @param array $properties
     */
    function __construct($properties = array())
    {
        foreach($properties as $key => $value)
        {
            if(property_exists($this, $key))
            {
                $this->{$key} = $value;
            }
        }

        $this->fieldsToValidate = get_object_vars($this);
        $this->validatorProperties = $this->validationProperties;
        $this->validatorMessages = $this->validationMessages;
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
