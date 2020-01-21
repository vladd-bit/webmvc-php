<?php

namespace Application\Core;

abstract class ValidationModelData
{
    protected array $modelFields = array();
    protected array $validationStatus = array();
    protected array $validatorProperties = array();
    protected array $validatorMessages = array();

    /**
     * @return array
     */
    public function getModelFields(): array
    {
        return $this->modelFields;
    }

    /**
     * @param array $modelFields
     */
    protected function setModelFields(array $modelFields): void
    {
        $this->modelFields = $modelFields;
    }

    /**
     * @return array
     */
    public function getValidationStatus(): array
    {
        return $this->validationStatus;
    }

    /**
     * @param array $validationStatus
     */
    protected function setValidationStatus(array $validationStatus): void
    {
        $this->validationStatus = $validationStatus;
    }

    /**
     * @return array
     */
    public function getValidatorProperties(): array
    {
        return $this->validatorProperties;
    }

    /**
     * @param array $validatorProperties
     */
    protected function setValidatorProperties(array $validatorProperties): void
    {
        $this->validatorProperties = $validatorProperties;
    }

    /**
     * @return array
     */
    public function getValidatorMessages(): array
    {
        return $this->validatorMessages;
    }

    /**
     * @param array $validatorMessages
     */
    protected function setValidatorMessages(array $validatorMessages): void
    {
        $this->validatorMessages = $validatorMessages;
    }
}