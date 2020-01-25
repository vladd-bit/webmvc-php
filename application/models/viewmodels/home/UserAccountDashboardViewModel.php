<?php

namespace Application\Models\ViewModels;

use Application\Core\BaseViewModel;

class UserAccountDashboardViewModel extends BaseViewModel
{
    public $username;

    public function __constructor()
    {}

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
}