<?php

namespace Application\Utils;

class ModelValidator
{
    private $validationAttributes = ['max','min','required','optional'];
    private $validationType = array('date' => 'date', 'email' => 'email', 'password' => 'password', 'lowerCharacters' => 'lowerCharacters','upperCharacters' => 'upperCharacters');
    private $validationMessage = array('error' => 'error', 'success' => 'success');

    private $fieldValidationMapping = array();


    /**
     *
     *    $this->validate($request, [
            'name' => 'required|max:10',
            'price' => 'required',
            ]);

     */

    /**
     * @return array
     */
    public function getValidationAttributes(): array
    {
        return $this->validationAttributes;
    }

    /**
     * @param array $validationAttributes
     */
    public function setValidationAttributes(array $validationAttributes): void
    {
        $this->validationAttributes = $validationAttributes;
    }

    /**
     * @return array
     */
    public function getValidationType(): array
    {
        return $this->validationType;
    }

    /**
     * @param array $validationType
     */
    public function setValidationType(array $validationType): void
    {
        $this->validationType = $validationType;
    }

    /**
     * @return array
     */
    public function getValidationMessage(): array
    {
        return $this->validationMessage;
    }

    /**
     * @param array $validationMessage
     */
    public function setValidationMessage(array $validationMessage): void
    {
        $this->validationMessage = $validationMessage;
    }

    /**
     * @return mixed contains validation logic for the model's fields.
     */
    public function isValid()
    {
        foreach ($this as $key => $value)
        {
            print "$key => $value\n";
        }
        return 0;
    }
}