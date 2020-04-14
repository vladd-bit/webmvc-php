<?php

namespace Application\Core;

abstract class ValidationDataType extends \SplEnum
{
    const __default = 'none';

    const email = 'email';
    const password = 'password';
    const datetime = 'datetime';
}
