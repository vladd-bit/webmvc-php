<?php

namespace Application\Utils;

use Application\Config\WebConfig;
use Application\Core\ValidationDataAnnotation;
use Application\Core\ValidationDataType;
use DateTime;

class ModelValidator
{
    private $fieldsToValidate = array();
    private $fieldValidationMapping = array();
    private $fieldValidationMessage = array();

    /**
     * @return array
     */
    public function getFieldsToBeValidated(): array
    {
        return $this->fieldsToValidate;
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
        echo '</br>///</br>';
        print_r($inputAttribute,0);
        echo '</br>///</br>';

        $currentMessage = null;
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
                                $currentMessage = $variableFieldName . ' must contain at least ' . current($inputAttribute) . ' upper characters';
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
                                $currentMessage = $variableFieldName . ' must contain at least ' . current($inputAttribute) . ' lower characters';
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



            /*
             *
             *   case ValidationDataAnnotation::validationMessage['success']:
                    if(isset($this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotation::validationMessage['success']]))
                    {
                        $currentMessage = $validationMessageContent;
                    }
                    else if(key($inputAttribute) == $validationMessageAttribute)
                    {

                    }
                    break;


             *   if(isset($this->fieldValidationMessage[$variableFieldName][ValidationDataAnnotation::validationMessage['error']]))
                    {
                        $currentMessage = $validationMessageContent;
                    }
                    else if(key($inputAttribute) == $validationMessageAttribute)
                    {
//
                    }
             */
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
            //$validationResult = [$validationResult[key($inputAttribute)] , 'error' => isset($this->fieldValidationMessage[$variableFieldName])  ? $this->fieldValidationMessage[$variableFieldName] : 'no'];
            $validationResult = [$validationResult[key($inputAttribute)], 'error' => $currentMessage ];
        }
        else if ($validationResult[key($inputAttribute)] == 1)
        {
            $validationResult[key($inputAttribute)] = [$validationResult[key($inputAttribute)], 'success' => ''];
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
        foreach($this->fieldsToValidate as $fieldName => $fieldValue)
        {
            foreach($this->fieldValidationMapping as $validationFieldName => $conditions)
            {
                if($fieldName == $validationFieldName)
                {
                    $extractedConditionsList = $this->extractValidationConditions($conditions);
                    echo '</br>============</br>';
                    echo '</br>============</br>';
                    echo '</br>============</br>';
                    //print_r($extractedConditionsList, 0);
                    print_r($this->checkInputValidity($fieldName, $fieldValue, $extractedConditionsList),0);
                    // $this->checkInputValidity($fieldName, $fieldValue, $extractedConditionsList);
                    break;
                }
            }
        }

        return false;
    }
}
