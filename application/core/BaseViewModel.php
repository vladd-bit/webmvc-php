<?php

namespace Application\Core;

use Application\Utils\ModelValidator;

class BaseViewModel
{
    protected $validatorProperties = array();
    protected $validatorMessages   = array();
    protected $fieldsToValidate = array();
    public $validationStatus = array();

    /**
     * @param string $fieldName
     * @return mixed|string
     */
    public function getValidationMessage(string $fieldName)
    {
        if(isset($this->validationStatus[$fieldName]))
        {
            return $this->validationStatus[$fieldName];
        }
        else
        {
            return '';
        }
    }

    public function isValid()
    {
        $modelValidator = new ModelValidator();
        $modelValidator->setFieldValidationMapping($this->validatorProperties);
        $modelValidator->setFieldValidationMessage($this->validatorMessages);
        $modelValidator->setFieldsToValidate($this->fieldsToValidate);

        $isValid = $modelValidator->isValid();
        $this->validationStatus = $modelValidator->getFieldValidationStatus();
        return $isValid;
    }
}