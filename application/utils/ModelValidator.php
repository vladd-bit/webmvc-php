<?php

namespace Application\Utils;

abstract class ModelValidator
{
    public $variableValidationAttributes = array();

    /**
     * @return mixed contains validation logic for the model's fields.
     */
    protected function isValid()
    {
        return 0;
    }
}