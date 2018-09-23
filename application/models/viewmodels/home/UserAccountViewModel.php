<?php

namespace Application\Models\ViewModels\Home;

use Application\Core\BaseViewModel;

class UserAccountViewModel extends BaseViewModel
{
    private $username;
    private $password;
    private $validationProperties = array('username' => 'required|maxLength:20|minLength:4|dataType:email|upperCharacters|displayFormat:{dd-MM-yyyy}',
                                          'password' => 'required|maxLength:30|minLength:10|upperCharacters:2|lowerCharacters:5');

    private $validationMessages   = array('username' => ['success' => 'great success','error' =>'this is a custom error message'],
                                          'password' => ['maxLength' =>'the username must be at least 4 characters', 'success' => 'great success','error' =>'this is a custom error message']
                                          );

    function __construct()
    {
        $this->validatorProperties = $this->validationProperties;
        $this->validatorMessages = $this->validationMessages;
        $this->fieldsToValidate = get_object_vars($this);
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
