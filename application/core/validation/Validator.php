<?php

namespace Application\Core;

use Application\Config\WebConfig;
use DateTime;

class Validator
{
    private array $fieldsToValidate = array();
    private array $fieldValidationMapping = array();
    private array $fieldValidationMessage = array();
    private array $results = array();
    private array $fieldValidationStatus= array();

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
        echo '<br>'; echo '<br>'; echo '<br>'; echo '<br>'; echo '<br>';
        echo $variableFieldName;
        echo "<p>=====</p>";
        print_r($inputAttribute,0);
        echo '<br>';

        print_r($validationResult, 0);
        $currentMessage = '';
        if(array_key_exists($variableFieldName, $this->fieldValidationMessage))
        {
            foreach($this->fieldValidationMessage[$variableFieldName] as $validationMessageAttribute => $validationMessageContent)
            {
                foreach(ValidationDataAnnotationType::validationAttributes as $validationDataAnnotationAttribute)
                {
                    switch ($validationDataAnnotationAttribute)
                    {
                        case ValidationDataAnnotationType::maxLength:
                            if(isset($this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotationType::maxLength]))
                            {
                                $currentMessage = $validationMessageContent;
                            }
                            else if(key($inputAttribute) == $validationDataAnnotationAttribute)
                            {
                                $currentMessage = $variableFieldName . ' can be maximum ' . current($inputAttribute).  ' characters';
                            }
                            break;

                        case ValidationDataAnnotationType::minLength:
                            if(isset($this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotationType::minLength]))
                            {
                                $currentMessage = $validationMessageContent;
                            }
                            else if(key($inputAttribute) == $validationDataAnnotationAttribute)
                            {
                                $currentMessage = $variableFieldName . ' must be minimum ' . current($inputAttribute). ' characters';
                            }
                            break;

                        case ValidationDataAnnotationType::required:
                            if(isset($this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotationType::required]))
                            {
                                $currentMessage = $validationMessageContent;
                            }
                            else if(key($inputAttribute) == $validationDataAnnotationAttribute)
                            {
                                $currentMessage = $variableFieldName . ' is required';
                            }
                            break;

                        case ValidationDataAnnotationType::upperCharacters:
                            if(isset($this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotationType::upperCharacters]))
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

                        case ValidationDataAnnotationType::lowerCharacters:
                            if(isset($this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotationType::lowerCharacters]))
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

                        case ValidationDataAnnotationType::dataType:
                            if(isset($this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotationType::dataType]))
                            {
                                # $currentMessage = $validationMessageContent;
                            }
                            else if(key($inputAttribute) == $validationDataAnnotationAttribute)
                            {

                            }
                            break;
                    }
                }
            }
        }

        if ($validationResult[key($inputAttribute)] == 0)
        {
            if(isset($this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotationType::validationMessageStatus[ValidationDataAnnotationType::error]]))
            {
                $currentMessage = $this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotationType::validationMessageStatus[ValidationDataAnnotationType::error]];
            }

            $validationResult[key($inputAttribute)] = [ValidationDataAnnotationType::error => $currentMessage];
        }
        else if ($validationResult[key($inputAttribute)] == 1)
        {
            if(isset($this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotationType::validationMessageStatus[ValidationDataAnnotationType::success]]))
            {
                $currentMessage = $this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotationType::validationMessageStatus[ValidationDataAnnotationType::success]];
            }
            else
            {
                $currentMessage = 'Valid field';
            }

            $validationResult[key($inputAttribute)] = [ValidationDataAnnotationType::success => $currentMessage];
        }

        return $validationResult;
    }

    private function checkInputValidity($variableFieldName, $variableFieldValue, $inputAttributes)
    {
        $validationResults = array();

        foreach($inputAttributes as $inputAttribute)
        {
            foreach (ValidationDataAnnotationType::validationAttributes as $validationAttribute)
            {
                if (key($inputAttribute) == $validationAttribute)
                {
                    switch (key($inputAttribute))
                    {
                        case ValidationDataAnnotationType::maxLength:
                            if (strlen($variableFieldValue) < reset($inputAttribute))
                            {
                                array_push($validationResults, [key($inputAttribute) => 1]);
                            }
                            else
                            {
                                array_push($validationResults, [key($inputAttribute) => 0]);
                            }
                            break;

                        case ValidationDataAnnotationType::minLength:
                            if (strlen($variableFieldValue) > reset($inputAttribute))
                            {
                                array_push($validationResults, [key($inputAttribute) => 1]);
                            }
                            else
                            {
                                array_push($validationResults, [key($inputAttribute) => 0]);
                            }
                            break;

                        case ValidationDataAnnotationType::optional:
                            break;

                        case ValidationDataAnnotationType::required:
                            if (isset($variableFieldValue) && trim($variableFieldValue) !== '')
                            {
                                array_push($validationResults, [key($inputAttribute) => 1]);
                            }
                            else
                            {
                                array_push($validationResults, [key($inputAttribute) => 0]);
                            }
                            break;

                        case ValidationDataAnnotationType::upperCharacters:
                            if (isset($variableFieldValue))
                            {
                                $inputVar = trim($variableFieldValue);
                                preg_match_all("/[A-Z]/", $inputVar, $capitalCaseCount);
                                $capsCount = count($capitalCaseCount [0]);

                                if($capsCount >= $inputAttribute[ValidationDataAnnotationType::upperCharacters])
                                {
                                    array_push($validationResults, [key($inputAttribute) => 1]);
                                }
                                else
                                {
                                    array_push($validationResults, [key($inputAttribute) => 0]);
                                }
                            }
                            else
                            {
                                array_push($validationResults, [key($inputAttribute) => 0]);
                            }
                            break;

                        case ValidationDataAnnotationType::lowerCharacters:
                            if (isset($variableFieldValue))
                            {
                                $inputVar = trim($variableFieldValue);
                                preg_match_all("/[a-z]/", $inputVar, $lowerCaseCount);
                                $lowCaseCount = count($lowerCaseCount[0]);
                                if($lowCaseCount >= $inputAttribute[ValidationDataAnnotationType::lowerCharacters])
                                {
                                    array_push($validationResults, [key($inputAttribute) => 1]);
                                }
                                else
                                {
                                    array_push($validationResults, [key($inputAttribute) => 0]);
                                }
                            }
                            else
                            {
                                array_push($validationResults, [key($inputAttribute) => 0]);
                            }
                            break;

                        case ValidationDataAnnotationType::dataType:
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
                            if($validityStatus == ValidationDataAnnotationType::error)
                            {
                                if($validationStatus == true)
                                    $validationStatus = false;
                            }

                            $this->fieldValidationStatus[$variableName] = [ValidationDataAnnotationType::validationMessageType => $validityStatus, ValidationDataAnnotationType::validationMessageContent => $validityMessage];
                        }
                    }
                }
            }
        }

        return $validationStatus;
    }
}
