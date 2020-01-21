<?php

namespace Application\Core;

use ReflectionClass;
use ReflectionProperty;

class BaseViewModel extends ValidationModelData
{
    function __construct()
    {
        $props  = (new ReflectionClass(get_class($this)))->getProperties(ReflectionProperty::IS_PRIVATE);

        foreach ($props as $prop)
        {
            array_push($this->modelFields, $prop->getName());
        }
    }

    /**
     * @param string $fieldName
     * @return mixed|string
     */
    public function getFieldValidationMessage($fieldName)
    {
        if(isset($this->validationStatus[$fieldName]))
        {
            return $this->validationStatus[$fieldName][ValidationDataAnnotation::validationMessageContent];
        }

        return '';
    }

    /**
     * @param string $fieldName
     * @return mixed|string
     */
    public function getFieldValidationStatus($fieldName)
    {
        if(isset($this->validationStatus[$fieldName]))
        {
            return $this->validationStatus[$fieldName][ValidationDataAnnotation::validationMessageType];
        }

        return '';
    }

    public function isValid()
    {
        $modelValidator = new ModelValidator();
        $modelValidator->setFieldValidationMapping($this->validatorProperties);
        $modelValidator->setFieldValidationMessage($this->validatorMessages);
        $modelValidator->setFieldsToValidate($this->modelFields);

        $isValid = $modelValidator->isValid();
        $this->validationStatus = $modelValidator->getFieldValidationStatus();

        return $isValid;
    }

    /**
     * @param array $properties
     */
    public function setFieldData($properties)
    {
        foreach($properties as $key => $value)
        {
            if(property_exists($this, $key))
            {
                $this->{$key} = $value;
            }
        }
    }
}