<?php

namespace Application\Core;

use ReflectionClass;
use ReflectionProperty;

class BaseViewModel extends ValidationModelData
{
    /**
     * BaseViewModel constructor.
     * @param array $field_data
     *
     * this should be an array of the field data,
     * used for initializing from an array of data,
     * note that in the case that this property is used,
     * the class extending the BaseViewModel class should have all of it's fields set as PROTECTED or PUBLIC,
     * not PRIVATE !.
     *
     * @throws \ReflectionException
     *
     * the fields of the Child class will be passed to the ValidationModelData  modelFields variable,
     * so that it will be used for validation or for setting the field/property values of the Child Class
     *
     */
    function __construct(array $field_data)
    {
        $props  = (new ReflectionClass(get_class($this)))->getProperties(ReflectionProperty::IS_PRIVATE |
            ReflectionProperty::IS_PROTECTED);

        foreach ($props as $field)
        {
            array_push($this->modelFields, $field->getName());
        }

        if(isset($field_data))
            $this->setFieldData($field_data);
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
            if(in_array($key, $this->modelFields))
            {
                $this->{$key} = $value;
            }
        }
    }
}