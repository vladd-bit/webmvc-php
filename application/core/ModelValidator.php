<?php

namespace Application\Core;

use Application\Config\WebConfig;
use DateTime;

class ModelValidator
{
    private $fieldsToValidate = array();
    private $fieldValidationMapping = array();
    private $fieldValidationMessage = array();

    private $results = array();
    private $fieldValidationStatus= array();

    /**
     * @return array of the fields that are to be validated
     */
    public function getFieldsToBeValidated(): array
    {
        return array(array_keys($this->fieldsToValidate));
    }

    /**
     * @param array $fieldsToValidate
     */
    public function setFieldsToValidate(array $fieldsToValidate): void
    {
        $this->fieldsToValidate = $fieldsToValidate;
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
     * @return array
     */
    public function getValidationResults(): array
    {
        return $this->results;
    }

    public function getFieldValidationStatus() : array
    {
        return $this->fieldValidationStatus;
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

        $validationAttributesList = array();

        foreach($formattedConditions as $condition)
        {
            $attribute = explode(':', $condition);
            if(is_array($attribute) && count($attribute) > 1 )
            {
               array_push($validationAttributesList, [ $attribute[0] => $attribute[1] ]);
            }
            else
            {
               array_push($validationAttributesList, [ $attribute[0] => 1 ]);
            }
        }

        return $validationAttributesList;
    }

    private function buildErrorMessageForField($variableFieldName, $inputAttribute, $validationResult)
    {
        $currentMessage = null;
        if(array_key_exists($variableFieldName, $this->fieldValidationMessage))
        {
            foreach($this->fieldValidationMessage[$variableFieldName] as $validationMessageAttribute => $validationMessageContent)
            {
                foreach(ValidationDataAnnotation::validationAttributes as $validationDataAnnotationAttribute)
                {
                    switch ($validationDataAnnotationAttribute)
                    {
                        case ValidationDataAnnotation::maxLength:
                            if(isset($this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotation::maxLength]))
                            {
                                $currentMessage = $validationMessageContent;
                            }
                            else if(key($inputAttribute) == $validationDataAnnotationAttribute)
                            {
                                $currentMessage = $variableFieldName . ' can be maximum ' . current($inputAttribute).  ' characters';
                            }
                            break;

                        case ValidationDataAnnotation::minLength:
                            if(isset($this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotation::minLength]))
                            {
                                $currentMessage = $validationMessageContent;
                            }
                            else if(key($inputAttribute) == $validationDataAnnotationAttribute)
                            {
                                $currentMessage = $variableFieldName . ' must be minimum ' . current($inputAttribute). ' characters';
                            }
                            break;

                        case ValidationDataAnnotation::required:
                            if(isset($this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotation::required]))
                            {
                                $currentMessage = $validationMessageContent;
                            }
                            else if(key($inputAttribute) == $validationDataAnnotationAttribute)
                            {
                                $currentMessage = $variableFieldName . ' is required';
                            }
                            break;

                        case ValidationDataAnnotation::upperCharacters:
                            if(isset($this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotation::upperCharacters]))
                            {
                                $currentMessage = $validationMessageContent;
                            }
                            else if(key($inputAttribute) == $validationDataAnnotationAttribute)
                            {
                                if(isset($inputAttribute[key($inputAttribute)]))
                                {
                                    if(current($inputAttribute) == 1)
                                    {
                                        $currentMessage = $variableFieldName . ' must contain at least ' . current($inputAttribute) . ' upper character';
                                    }
                                    else
                                    {
                                        $currentMessage = $variableFieldName . ' must contain at least ' . current($inputAttribute) . ' upper characters';
                                    }
                                }
                                else
                                {
                                    $currentMessage = $variableFieldName . ' must contain upper characters';
                                }
                            }
                            break;

                        case ValidationDataAnnotation::lowerCharacters:
                            if(isset($this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotation::lowerCharacters]))
                            {
                                $currentMessage = $validationMessageContent;
                            }
                            else if(key($inputAttribute) == $validationDataAnnotationAttribute)
                            {
                                if(isset($inputAttribute[key($inputAttribute)]))
                                {
                                    if(current($inputAttribute) == 1)
                                    {
                                        $currentMessage = $variableFieldName . ' must contain at least ' . current($inputAttribute) . ' lower character';
                                    }
                                    else
                                    {
                                        $currentMessage = $variableFieldName . ' must contain at least ' . current($inputAttribute) . ' lower characters';
                                    }
                                }
                                else
                                {
                                    $currentMessage = $variableFieldName . ' must contain lower characters';
                                }
                            }
                            break;

                        case ValidationDataAnnotation::dataType:
                            if(isset($this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotation::dataType]))
                            {
                                $currentMessage = $validationMessageContent;
                            }
                            else if(key($inputAttribute) == $validationDataAnnotationAttribute)
                            {

                            }
                            break;
                    }
                }
            }
        }

        if(!isset($currentMessage))
        {
            if(isset($this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotation::validationMessage['error']]))
            {
                $currentMessage = $this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotation::validationMessage['error']];
            }
        }

        if ($validationResult[key($inputAttribute)] == 0)
        {
            $validationResult[key($inputAttribute)] = ['error' => $currentMessage ];
        }
        else if ($validationResult[key($inputAttribute)] == 1)
        {
            $validationResult[key($inputAttribute)] = ['success' => 'looking good'];
        }

        return $validationResult;
    }

    private function checkInputValidity($variableFieldName, $variableFieldValue, $inputAttributes)
    {
        $validationResults = array();

        foreach($inputAttributes as $inputAttribute)
        {
            foreach (ValidationDataAnnotation::validationAttributes as $validationAttribute)
            {
                if (key($inputAttribute) == $validationAttribute)
                {
                    switch (key($inputAttribute))
                    {
                        case ValidationDataAnnotation::maxLength:
                            if (strlen($variableFieldValue) < reset($inputAttribute))
                            {
                                array_push($validationResults, [key($inputAttribute) => 1]);
                            }
                            else
                            {
                                array_push($validationResults, [key($inputAttribute) => 0]);
                            }
                            break;

                        case ValidationDataAnnotation::minLength:
                            if (strlen($variableFieldValue) > reset($inputAttribute))
                            {
                                array_push($validationResults, [key($inputAttribute) => 1]);
                            }
                            else
                            {
                                array_push($validationResults, [key($inputAttribute) => 0]);
                            }
                            break;

                        case ValidationDataAnnotation::optional:
                            break;

                        case ValidationDataAnnotation::required:
                            if (isset($variableFieldValue) && trim($variableFieldValue) !== '')
                            {
                                array_push($validationResults, [key($inputAttribute) => 1]);
                            }
                            else
                            {
                                array_push($validationResults, [key($inputAttribute) => 0]);
                            }
                            break;

                        case ValidationDataAnnotation::upperCharacters:
                            if (isset($variableFieldValue))
                            {
                                $inputVar = trim($variableFieldValue);
                                preg_match_all("/[A-Z]/", $inputVar, $upperCaseCount);
                                $capsCount = count($upperCaseCount [0]);
                                if($capsCount >= $inputAttribute[ValidationDataAnnotation::upperCharacters])
                                {
                                    array_push($validationResults, [key($inputAttribute) => 1]);
                                }
                                {
                                    array_push($validationResults, [key($inputAttribute) => 0]);
                                }
                            }
                            else
                            {
                                array_push($validationResults, [key($inputAttribute) => 0]);
                            }
                            break;

                        case ValidationDataAnnotation::lowerCharacters:
                            if (isset($variableFieldValue))
                            {
                                $inputVar = trim($variableFieldValue);
                                preg_match_all("/[a-z]/", $inputVar, $lowerCaseCount);
                                $lowCaseCount = count($lowerCaseCount [0]);
                                if($lowCaseCount >= $inputAttribute[ValidationDataAnnotation::lowerCharacters])
                                {
                                    array_push($validationResults, [key($inputAttribute) => 1]);
                                }
                                {
                                    array_push($validationResults, [key($inputAttribute) => 0]);
                                }
                            }
                            else
                            {
                                array_push($validationResults, [key($inputAttribute) => 0]);
                            }
                            break;

                        case ValidationDataAnnotation::dataType:
                            {
                                switch (reset($inputAttribute))
                                {
                                    case ValidationDataType::datetime:
                                        if (DateTime::createFromFormat(WebConfig::DEFAULT_DATETIME_FORMAT, $variableFieldValue) !== false)
                                        {
                                            array_push($validationResults, [key($inputAttribute) => 1]);
                                        }
                                        else
                                        {
                                            array_push($validationResults, [key($inputAttribute) => 0]);
                                        }

                                        break;

                                    case ValidationDataType::email:
                                        if (filter_var($variableFieldValue, FILTER_VALIDATE_EMAIL))
                                        {
                                            array_push($validationResults, [key($inputAttribute) => 1]);
                                        }
                                        else
                                        {
                                            array_push($validationResults, [key($inputAttribute) => 0]);
                                        }

                                        break;

                                    case ValidationDataType::password:
                                        break;
                                }
                            }
                            break;
                    }
                    $validationResults[count($validationResults) - 1] = $this->buildErrorMessageForField($variableFieldName, $inputAttribute, $validationResults[count($validationResults) - 1]);
                }
            }


        }

        $validationResults = [$variableFieldName => $validationResults];

        return $validationResults;
    }

    /**
     * @return mixed contains validation logic for the model's fields.
     */
    public function isValid()
    {
        $validationStatus = true;

        foreach($this->fieldsToValidate as $fieldName => $fieldValue)
        {
            foreach($this->fieldValidationMapping as $validationFieldName => $conditions)
            {
                if($fieldName == $validationFieldName)
                {
                    $extractedConditionsList = $this->extractValidationConditions($conditions);
                    $this->results[$validationFieldName] = $this->checkInputValidity($fieldName, $fieldValue, $extractedConditionsList);
                    break;
                }
            }
        }

        foreach($this->results as $key => $value)
        {
            $value  = is_array($value) ? $value  : array($value);

            foreach($value as $variableName => $attribute)
            {
                $attribute  = is_array($attribute) ? $attribute  : array($attribute);

                foreach($attribute as $index => $attributeValue)
                {
                    $attributeValue  = is_array($attributeValue) ? $attributeValue  : array($attributeValue);

                    foreach($attributeValue as $v => $k)
                    {
                        $k  = is_array($k) ? $k  : array($k);

                        foreach($k as $validityStatus => $validityMessage)
                        {
                            if($validityStatus == ValidationDataAnnotation::error)
                            {
                                $validationStatus = false;
                            }
                            if(isset($validityMessage))
                            {
                                $this->fieldValidationStatus[$variableName] = $validityMessage;
                            }
                        }
                    }
                }
            }
        }

        return $validationStatus;
    }
}
