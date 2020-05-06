<?php

namespace Application\Core;

abstract class ValidationDataType extends \SplEnum
{
    const __default = 'none';

    /**
     * @email is used to check if the field is a valid email format
     */
    const email = 'email';

    /**
     *
     */
    const password = 'password';
}
