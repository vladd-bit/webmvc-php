<?php

namespace Application\Models\ViewModels;

use Application\Core\BaseViewModel;

class UserAccountDashboardViewModel extends BaseViewModel
{
    private $username;

    public function __constructor($properties)
    {
        if(isset($properties))
            $this->setFieldData($properties);
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
}