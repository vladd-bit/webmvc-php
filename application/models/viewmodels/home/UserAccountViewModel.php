<?php

namespace Application\Models\ViewModels\Home;

use Application\Utils\ModelValidator;

class UserAccountViewModel
{
    private $username;
    private $password;
    private $validationProperties = array('username' => 'required|maxLength:20|minLength:4|dataType:email|displayFormat:{dd-MM-yyyy}', 'password' => 'required|maxLength:30|minLength:10');
    private $validationMessages   = array('username' => ['maxLength' =>'the username must be at least 4 characters', 'success' => ''],
                                          'password' => ['maxLength' =>'the username must be at least 4 characters', 'success' => '']
                                          );

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

    public function isValid()
    {
        $modelValidator = new ModelValidator();
        $modelValidator->setFieldValidationMapping($this->validationProperties);
        $modelValidator->setFieldValidationMessage($this->validationMessages);
        $modelValidator->setFieldsToBeValidated(get_object_vars($this));

        return $modelValidator->isValid();
    }
}