<?php

namespace Application\Utils;

class ModelValidator
{
    private $validationAttributes = ['maxLength','minLength','required','optional','lowerCharacters' => 'lowerCharacters','upperCharacters' => 'upperCharacters'];
    private $validationType = array('date' => 'date', 'email' => 'email', 'password' => 'password');
    private $validationMessage = array('error' => 'error', 'success' => 'success');

    private $fieldsToBeValidated = array();
    private $fieldValidationMapping = array();
    private $fieldValidationMessage = array();

    /**
     * @return array
     */
    public function getFieldsToBeValidated(): array
    {
        return $this->fieldsToBeValidated;
    }

    /**
     * @param array $fieldsToBeValidated
     */
    public function setFieldsToBeValidated(array $fieldsToBeValidated): void
    {
        $this->fieldsToBeValidated = $fieldsToBeValidated;
    }

    /**
     * @return array
     */
    public function getFieldValidationMapping(): array
    {
        return $this->fieldValidationMapping;
    }

    /**
     * @param array $fieldValidationMapping
     */
    public function setFieldValidationMapping(array $fieldValidationMapping): void
    {
        $this->fieldValidationMapping = $fieldValidationMapping;
    }

    /**
     * @return array
     */
    public function getFieldValidationMessage(): array
    {
        return $this->fieldValidationMessage;
    }

    /**
     * @param array $fieldValidationMessage
     */
    public function setFieldValidationMessage(array $fieldValidationMessage): void
    {
        $this->fieldValidationMessage = $fieldValidationMessage;
    }

    private function extractValidationConditions($conditions)
    {
        $formattedConditions = explode('|', $conditions);

        return $formattedConditions;
    }

    /**
     * @return mixed contains validation logic for the model's fields.
     */
    public function isValid()
    {
        foreach($this->fieldsToBeValidated as $fieldName => $fieldValue)
        {
            foreach($this->fieldValidationMapping as $validationFieldName => $conditions)
            {
                if($fieldName == $validationFieldName)
                {
                    $this->extractValidationConditions($conditions);
                }

                break;
            }
        }

        return false;
    }
}