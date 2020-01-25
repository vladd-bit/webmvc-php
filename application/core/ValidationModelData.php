<?php

namespace Application\Core;

abstract class ValidationModelData
{
    protected static array $modelFields = array();
    private array $validationStatus = array();
    private array $validatorProperties = array();
    private array $validatorMessages = array();

    /**
     * @return array
     */
    protected static function getModelFields(): array
    {
        return self::$modelFields;
    }

    /**
     * @param array $modelFields
     */
    protected function setModelFields(array $modelFields): void
    {
        self::$modelFields = $modelFields;
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