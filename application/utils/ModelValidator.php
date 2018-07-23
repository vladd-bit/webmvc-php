<?php

namespace Application\Utils;

use DateTime;

class ModelValidator
{
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

    private function buildErrorMessageForFields($variableFieldName, $inputAttribute, $validationResult)
    {
       if($validationResult[key($inputAttribute)] == 0)
       {
            $validationResult = [$validationResult[key($inputAttribute)] , 'error' => 'some error'];
       }
       else if($validationResult[key($inputAttribute)] == 1)
       {
            $validationResult[key($inputAttribute)] = [$validationResult[key($inputAttribute)] , 'success' => 'success'];
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
                            break;

                        case ValidationDataAnnotation::lowerCharacters:
                            break;

                        case ValidationDataAnnotation::dataType:
                            {
                                switch (reset($inputAttribute))
                                {
                                    case ValidationDataType::datetime:
                                        if (DateTime::createFromFormat('Y-m-d G:i:s', $variableFieldValue) !== false)
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

                    $validationResults[count($validationResults) - 1] = $this->buildErrorMessageForFields($variableFieldName, $inputAttribute, $validationResults[count($validationResults) - 1]);
                }
            }


        }

        $validationResults = [$variableFieldName => $validationResults];

        //echo '</br> RESULT </br>';
        //print_r($validationResults, 0);

        //echo '</br>';
        //echo $variableFieldName;
        //echo '  ';
        //echo $variableFieldValue;
        //echo '  ';
        //print_r($inputAttributes);
        //echo '</br>';

        return $validationResults;
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
                    $extractedConditionsList = $this->extractValidationConditions($conditions);
                    echo '</br>============</br>';
                    print_r($this->checkInputValidity($fieldName, $fieldValue, $extractedConditionsList),0);
                    //$this->checkInputValidity($fieldName, $fieldValue, $extractedConditionsList);
                }
            }
        }

        return false;
    }
}