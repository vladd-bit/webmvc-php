<?php

namespace Application\Models\ViewModels;

use Application\Core\ViewModel;

class UserAccountViewModel extends ViewModel
{
    public $username;
    public $password;
    public $confirmPassword;
    public $email;

    public function __construct()
    {
        $this->setValidationFieldProperties(array(
            'username' => 'required|maxLength:20|minLength:4',
            'password' => 'required|maxLength:30|minLength:4|numerals:2|lowerCharacters:4',
            'confirmPassword' => 'required|maxLength:30|minLength:4|numerals:2|lowerCharacters:4',
            'email' => 'required|dataType:email'));

        $this->setValidationFieldMessages(array('username' => ['success' => 'checks out'],
                                                'password' => ['error' => 'passwords do not match'],
                                                'email' => ['error' => 'invalid email format',
                                                'maxLength' => ['success' => 'maxLengthSuccess',
                                                'error' => 'MAX length custom error message']]
                                          ));
    }
}
