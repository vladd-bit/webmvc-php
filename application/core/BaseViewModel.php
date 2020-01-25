<?php

namespace Application\Core;

use Application\models\viewmodels\home\UserAccountLoginViewModel;
use ReflectionClass;
use ReflectionProperty;

class BaseViewModel extends ValidationModelData
{

    /**
     * BaseViewModel constructor.
     * @param array $field_data OPTIONAL
     *
     * this should be an array of the field data,
     * used for initializing from an array of data,
     * note that in the case that this property is used,
     * the class extending the BaseViewModel class should have all of it's fields set as PROTECTED or PUBLIC,
     * not PRIVATE !.
     *
     * the fields of the Child class will be passed to the ValidationModelData  modelFields variable,
     * so that it will be used for validation or for setting the field/property values of the Child Class
     *
     */

    function __construct(array $field_data = array())
    {
        self::buildPropertyList();

        if(isset($field_data))
            $this->setFieldData($field_data);
    }

    public static function getModelFields(): array
    {
        if(empty(self::$modelFields))
        {
            self::buildPropertyList();
        }

        return parent::getModelFields();
    }

    public static function buildPropertyList()
    {
        try
        {
            $props  = (new ReflectionClass(get_called_class()))->getProperties(
                ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC
            );

            foreach ($props as $field)
            {
                array_push(self::$modelFields, $field->getName());
            }
        }
        catch (\ReflectionException $exception)
        {
            Error::log(ErrorLogType::webError, $exception);
        }
    }

    /**
     * @param string $fieldName
     * @return mixed|string
     */
    public function getFieldValidationMessage($fieldName)
    {
        if(isset($this->getValidationStatus()[$fieldName]))
        {
            return $this->getValidationStatus()[$fieldName][ValidationDataAnnotation::validationMessageContent];
        }

        return '';
    }

    /**
     * @param string $fieldName
     * @return mixed|string
     */
    public function getFieldValidationStatus($fieldName)
    {
        if(isset($this->getValidationStatus()[$fieldName]))
        {
            return $this->getValidationStatus()[$fieldName][ValidationDataAnnotation::validationMessageType];
        }

        return '';
    }

    public function isValid()
    {
        $modelValidator = new ModelValidator();
        $modelValidator->setFieldValidationMapping($this->getValidatorProperties());
        $modelValidator->setFieldValidationMessage($this->getValidatorMessages());
        $modelValidator->setFieldsToValidate(self::$modelFields);

        $isValid = $modelValidator->isValid();
        $this->setValidationStatus($modelValidator->getFieldValidationStatus());

        return $isValid;
    }

    /**
     * @param array $properties
     */
    public function setFieldData(array $properties)
    {
        foreach($properties as $key => $value)
        {
            if(in_array($key, self::$modelFields))
            {
                $this->{$key} = $value;
            }
        }
    }
}