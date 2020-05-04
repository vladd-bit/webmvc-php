<?php

namespace Application\Models\ViewModels;

use Application\Core\ViewModel;

class UserAccountLoginViewModel extends ViewModel
{
    public $username;
    public $password;

    public function __constructor()
    {
        $this->setValidatorProperties(array('username' => 'required',
                                            'password' => 'required'
        ));

        $this->setValidatorMessages(array('username' => [''],
            'password' => []));
    }
}