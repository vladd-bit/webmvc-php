<?php

namespace Application\models\viewmodels\home;

use Application\Core\BaseViewModel;

class UserAccountLoginViewModel extends BaseViewModel
{
    public ?string $username = '';
    public ?string $password = '';

    public function __constructor()
    {
        $this->setValidatorProperties(array('username' => 'required',
                                            'password' => 'required'
        ));

        $this->setValidatorMessages(array('username' => [''],
            'password' => []));
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

}