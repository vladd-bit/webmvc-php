<?php

namespace Application\Core\Validation;

final class ValidationStatus
{
    public ?string $status = null;
    public ?string $validationMessage = null;

    function __construct($status = "", $validationMessage = "")
    {
        $this->status = $status;
        $this->validationMessage = $validationMessage;
    }
}

abstract class ValidationModelData
{
    /**
     * @var array $validationFields
     * Contains a dictionary of each public field of a model along with it's value.
     */
    private array $validationFields = array();

    /**
     * @var array
     * Contains the final validation status of the fields :  'fieldName' => ['error/success'=> 'message']
     */
    private array $validationFieldStatus = array();

    /**
     * @var array
     * Contains a dictionary of each field's set properties (defined in a ViewModel's constructor usually), for example
     * maxLength:5, upperCase:4, dataType:email, etc.
     */
    private array $validationFieldProperties = array();

    /**
     * @var array
     * Contains a dictionary of each field's message display in case of success/error.
     * Example: field  ['username' => ['success' => 'looks ok' , 'error' => 'incorrect username',
     * 'maxLength' => 'username exceeds the maximum allowed length']] .
     */
    private array $validationFieldMessages = array();

    /**
     * @return array
     */
    public function getValidationFields(): array
    {
        return $this->validationFields;
    }

    /**
     * @param array $validationFields
     */
    protected function setValidationFields(array $validationFields): void
    {
        $this->validationFields = $validationFields;
    }

    /**
     * @param $fieldName
     * @return mixed|string
     */
    public function getFieldValidationStatus(string $fieldName): ValidationStatus
    {
        if(isset($this->validationFieldStatus[$fieldName]))
        {
            return $this->validationFieldStatus[$fieldName];
        }

        return new ValidationStatus('', '');
    }

    /**
     * @param array $validationFieldStatus
     */
    public function setValidationFieldStatus(array $validationFieldStatus): void
    {
        $this->validationFieldStatus = $validationFieldStatus;
    }

    /**
     * @param string $fieldName
     * @return array
     */
    public function getValidationFieldMessage(string $fieldName)
    {
        if(isset($this->validationFieldMessages[$fieldName]))
            return $this->validationFieldMessages[$fieldName];

        return array();
    }

    public function getAllFieldValidationStatus(): array
    {
        return $this->validationFieldStatus;
    }

    /**
     * @param string $fieldName
     * @return array
     */
    public function getValidationFieldProperties(string $fieldName)
    {
        if(isset($this->validationFieldProperties[$fieldName]))
            return $this->validationFieldProperties[$fieldName];

        return array();
    }

    /**
     * @param array $validationFieldProperties
     */
    public function setValidationFieldProperties(array $validationFieldProperties): void
    {
        $this->validationFieldProperties = $validationFieldProperties;
    }

    /**
     * @return array
     */
    public function getValidationFieldMessages(): array
    {
        return $this->validationFieldMessages;
    }

    /**
     * @param array $validationFieldMessages
     */
    public function setValidationFieldMessages(array $validationFieldMessages): void
    {
        $this->validationFieldMessages = $validationFieldMessages;
    }
}