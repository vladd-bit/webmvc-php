<?php

namespace Application\Core\Authentication;

interface IAuthentication
{
    public static function isAuthorized(): bool;
}