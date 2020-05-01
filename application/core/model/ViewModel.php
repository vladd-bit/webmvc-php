<?php

namespace Application\Core;

use Application\Core\Handlers\Error\Error;
use Application\Core\Handlers\Error\ErrorLogType;
use ReflectionClass;
use ReflectionProperty;

abstract class ViewModel extends ValidationModelData
{
    /**
     * the class extending the base ViewModel class should have all of it's fields set as PROTECTED or PUBLIC,
     * not PRIVATE .
     *
     * the fields of the Child class will be passed to the ValidationModelData  modelFields variable,
     * so that it will be used for validation or for setting the field/property values of the Child Class
     *
     */

    function __construct()
    {}

    public static function getModelFields(): array
    {
        return array_keys(self::buildPropertyList());
    }

    private static function buildPropertyList()
    {
        $fields = array();

        try
        {
            $props  = (new ReflectionClass(static::class))->getProperties(ReflectionProperty::IS_PUBLIC);

            foreach ($props as $field)
            {
                $fields[$field->getName()] = NULL;
            }
        }
        catch (\ReflectionException $exception)
        {
            Error::log(ErrorLogType::webError, $exception);
        }

        return $fields;
    }

    /**
     * @param string $fieldName
     * @return string
     *
     * Returns the validation message for the field, otherwise it will return '' if field has no validation message set.
     */
     public function getFieldValidationMessage($fieldName)
     {
         #if(isset($this->getValidationStatus()[$fieldName]))
         #{
         #    return $this->getValidationStatus()[$fieldName][ValidationDataAnnotationType::validationMessageContent];
         #}

         return '';
     }

    /**
     * @param string $fieldName
     * @return string
     *
     * Returns the correct validation data type for the field if set,
     * otherwise it will return '' if field has not validation message type set.
     */
     public function getFieldValidationStatus($fieldName)
     {
        #if(isset($this->getFieldValidationStatus()[$fieldName]))
        #{
        #    return $this->getValidationStatus()[$fieldName][ValidationDataAnnotationType::validationMessageType];
        #}

         return '';
     }

    /**
     * @param array $viewModelFieldData
     * @return bool
     *
     * Verifies if the model's data fields are valid according to the properties set. Returns true if valid and false
     * if there are no field values set.
     */
    public function isValid(array $viewModelFieldData = array()): bool
    {
        if(empty($this->getValidationFields()) && empty($viewModelFieldData))
            return false;

        if(!empty($viewModelFieldData))
            $this->setFieldData($viewModelFieldData);

        $modelValidator = new Validator();

        return $modelValidator->isValid($this);
    }

    /**
     * @param array $viewModelFieldData
     */
    public function setFieldData(array $viewModelFieldData): void
    {
        $validationFields = self::buildPropertyList();
        $validFields = array_keys($validationFields);

        foreach($viewModelFieldData as $key => $value)
        {
            if (in_array($key, $validFields))
            {
                $this->{$key} = $value;
                $validationFields[$key] = $value;
            }
        }

        $this->setValidationFields($validationFields);
    }
}