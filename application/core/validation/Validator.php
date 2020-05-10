<?php

namespace Application\Core;

use Application\Config\WebConfig;
use Application\Core\Handlers\Error\Error;
use Application\Core\Handlers\Error\ErrorLogType;
use Application\Core\Validation\IValidator;
use Application\Core\Validation\ValidationModelData;
use Application\Core\Validation\ValidationStatus;
use DateTime;

class Validator implements IValidator
{
    /**
     * @param $conditions
     * @return array
     *
     * Extracts the validation conditions for a field as in the following example:
     *  'username' => 'required|maxLength:20',
     *  'date' => 'dataType:dateTime[mm-dd-yy]',
     *  -------------------------------------------------------------
     *  step 1:
     *  username : $conditions = 'required|maxLength:20
     *  date : $conditions = 'dataType:dateTime'
     *  step 2:
     *  username: $formattedConditions = ['required', 'maxLength:20']
     *            $validationAttributeList = ['required' => 1, 'maxLength' => 20]
     *  date: $formattedConditions = ['dataType:dateTime]
     *        $subconditions = ['dateTime' => 1]
     *        $validationAttributeList = ['dataType' => dateTime ]
     */
    public function extractValidationConditions($conditions): array
    {
        $formattedConditions = explode('|', trim($conditions));

        $validationAttributesList = array();

        foreach ($formattedConditions as $condition)
        {
            $attribute = explode(':', $condition);
            if (is_array($attribute) && count($attribute) > 1)
            {
                $validationAttributesList[$attribute[0]] = $attribute[1];
            }
            else
            {
                $validationAttributesList[$attribute[0]] = 1;
            }
        }

        return $validationAttributesList;
    }

    /**
     * @param $fieldName
     * @param $validationPropertyConditions
     * @param $validationPropertyResults
     * @param $validationMessages
     * @param $modelFieldsAndValues
     * @return array
     */
    public function buildErrorMessageForField($fieldName, $validationPropertyConditions,
                                               $validationPropertyResults, $validationMessages,
                                              $modelFieldsAndValues): array
    {
        $validationMessagesResults = array();

        foreach ($validationPropertyResults as $propertyName => $isValid)
        {
            foreach (ValidationDataAnnotationType::validationAttributes as $validationAttribute)
            {
                if($propertyName == $validationAttribute)
                {
                    switch($validationAttribute)
                    {
                        case ValidationDataAnnotationType::maxLength:
                            {
                                if($isValid)
                                {
                                    $validationMessagesResults[$propertyName] =
                                        'contains no more than ' .
                                        $validationPropertyConditions[$propertyName] .  ' character(s)';
                                }
                                else
                                {
                                    $validationMessagesResults[$propertyName] =
                                        ' can contain a maximum of '
                                        . $validationPropertyConditions[$propertyName] .  ' character(s)';
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::minLength:
                            {
                                if($isValid)
                                {
                                    $validationMessagesResults[$propertyName] =
                                        'contains at least ' .
                                        $validationPropertyConditions[$propertyName] .  ' character(s)';
                                }
                                else
                                {
                                    $validationMessagesResults[$propertyName] =
                                        ' must be at least '
                                        . $validationPropertyConditions[$propertyName] .  ' character(s) long';
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::required:
                            if(!$isValid)
                            {
                                $validationMessagesResults[$propertyName] = 'field required';
                            }
                            break;

                        case ValidationDataAnnotationType::upperCharacters:
                            if($isValid)
                            {
                                $validationMessagesResults[$propertyName] =' contains at least ' .
                                    $validationPropertyConditions[$propertyName] . ' upper character(s)';
                            }
                            else
                            {
                                $validationMessagesResults[$propertyName] = ' must contain at least ' .
                                    $validationPropertyConditions[$propertyName] . ' upper character(s)';
                            }
                            break;

                        case ValidationDataAnnotationType::lowerCharacters:
                            if($isValid)
                            {
                                $validationMessagesResults[$propertyName] = ' contains at least ' .
                                    $validationPropertyConditions[$propertyName] . ' lower character(s)';
                            }
                            else
                            {
                                $validationMessagesResults[$propertyName] = ' must contain at least ' .
                                    $validationPropertyConditions[$propertyName] . ' lower character(s)';
                            }
                            break;

                        case ValidationDataAnnotationType::symbols:
                            if($isValid)
                            {
                                $validationMessagesResults[$propertyName] =  ' contains at least ' .
                                    $validationPropertyConditions[$propertyName] . ' special character(s)';
                            }
                            else
                            {
                                $validationMessagesResults[$propertyName] = ' must contain at least ' .
                                    $validationPropertyConditions[$propertyName] . ' special character(s)';
                            }
                            break;

                        case ValidationDataAnnotationType::numerals:
                            if($isValid)
                            {
                                $validationMessagesResults[$propertyName] = ' contains at least ' .
                                    $validationPropertyConditions[$propertyName] . ' number(s)';
                            }
                            else
                            {
                                $validationMessagesResults[$propertyName] = ' must contain at least ' .
                                    $validationPropertyConditions[$propertyName] . ' number(s)';
                            }
                            break;

                        case ValidationDataAnnotationType::dateFormat:
                            if($isValid)
                            {
                                $validationMessagesResults[$propertyName] = 'date is valid';
                            }
                            else
                            {
                                $validationMessagesResults[$propertyName] = 'invalid date';
                            }
                            break;

                        case ValidationDataAnnotationType::dateAfter:
                            if($isValid)
                            {
                                $validationMessagesResults[$propertyName] = ''  ;
                            }
                            else
                            {
                                $validationMessagesResults[$propertyName] = 'date must not exceed ' . $validationPropertyConditions[$propertyName];
                            }
                            break;

                        case ValidationDataAnnotationType::dateBefore:
                            if($isValid)
                            {
                                $validationMessagesResults[$propertyName] = '';
                            }
                            else
                            {
                                $validationMessagesResults[$propertyName] = 'date must be before ' . $validationPropertyConditions[$propertyName];
                            }
                            break;

                        case ValidationDataAnnotationType::equalTo:
                            {
                                if(array_key_exists($propertyName, $validationPropertyConditions[$fieldName]))
                                {
                                    if($isValid)
                                    {
                                        $validationMessagesResults[$propertyName] = 'matches ' . $fieldName;
                                    }
                                    else
                                    {
                                        $validationMessagesResults[$propertyName] = 'field does not match ' . $fieldName;
                                    }
                                }
                                else if($isValid)
                                {
                                    $validationMessagesResults[$propertyName] =
                                        'is equal to ' . $validationPropertyConditions[$propertyName];
                                }
                                else
                                {
                                    $validationMessagesResults[$propertyName] =
                                        'field must be equal to '. $validationPropertyConditions[$propertyName];
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::greaterThanEqual:
                            {
                                if(array_key_exists($propertyName, $validationPropertyConditions[$fieldName]))
                                {
                                    if($isValid)
                                    {
                                        $validationMessagesResults[$propertyName] = 'is greater or equal than ' . $fieldName;
                                    }
                                    else
                                    {
                                        $validationMessagesResults[$propertyName] = 'must be greater or equal than' . $fieldName;
                                    }
                                }
                                else if($isValid)
                                {
                                    $validationMessagesResults[$propertyName] = 'is greater or equal than' .
                                        $validationPropertyConditions[$propertyName];
                                }
                                else
                                {
                                    $validationMessagesResults[$propertyName] = 'must be greater or equal than' .
                                        $validationPropertyConditions[$propertyName];
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::lowerThanEqual:
                            {
                                if(array_key_exists($propertyName, $validationPropertyConditions[$fieldName]))
                                {
                                    if($isValid)
                                    {
                                        $validationMessagesResults[$propertyName] = 'is lower or equal than ' . $fieldName;
                                    }
                                    else
                                    {
                                        $validationMessagesResults[$propertyName] = 'must be lower or equal than' . $fieldName;
                                    }
                                }
                                else if($isValid)
                                {
                                    $validationMessagesResults[$propertyName] = 'is lower or equal than' .
                                        $validationPropertyConditions[$propertyName];
                                }
                                else
                                {
                                    $validationMessagesResults[$propertyName] = 'must be lower or equal than' .
                                        $validationPropertyConditions[$propertyName];
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::greaterThan:
                            {
                                if(array_key_exists($propertyName, $validationPropertyConditions[$fieldName]))
                                {
                                    if($isValid)
                                    {
                                        $validationMessagesResults[$propertyName] = 'is greater than ' . $fieldName;
                                    }
                                    else
                                    {
                                        $validationMessagesResults[$propertyName] = 'must be grater than' . $fieldName;
                                    }
                                }
                                else if($isValid)
                                {
                                    $validationMessagesResults[$propertyName] = 'is greater than ' .
                                        $validationPropertyConditions[$propertyName];
                                }
                                else
                                {
                                    $validationMessagesResults[$propertyName] = 'must be greater than ' .
                                        $validationPropertyConditions[$propertyName];
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::lowerThan:
                            {
                                if(array_key_exists($propertyName, $validationPropertyConditions[$fieldName]))
                                {
                                    if($isValid)
                                    {
                                        $validationMessagesResults[$propertyName] = 'is lower than ' . $fieldName;
                                    }
                                    else
                                    {
                                        $validationMessagesResults[$propertyName] = 'must be lower than' . $fieldName;
                                    }
                                }
                                else if($isValid)
                                {
                                    $validationMessagesResults[$propertyName] = 'is lower than ' .
                                        $validationPropertyConditions[$propertyName];
                                }
                                else
                                {
                                    $validationMessagesResults[$propertyName] = 'must be lower than ' .
                                        $validationPropertyConditions[$propertyName];
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::dataType:
                            {
                                switch ($validationPropertyConditions[$propertyName])
                                {
                                    case ValidationDataType::email:
                                        if($isValid)
                                        {
                                            $validationMessagesResults[$propertyName] = 'valid email';
                                        }
                                        else
                                        {
                                            $validationMessagesResults[$propertyName] = 'invalid email format';
                                        }
                                        break;

                                    case ValidationDataType::phoneNumber:
                                        if($isValid)
                                        {
                                            $validationMessagesResults[$propertyName] = 'valid phone number';
                                        }
                                        else
                                        {
                                            $validationMessagesResults[$propertyName] = 'invalid phone number';
                                        }
                                        break;

                                    case ValidationDataType::password:
                                        if($isValid)
                                        {
                                            $validationMessagesResults[$propertyName] = 'valid password';
                                        }
                                        else
                                        {
                                            $validationMessagesResults[$propertyName] = 'invalid password';
                                        }
                                        break;
                                }
                            }
                            break;

                        default:
                            break;
                    }

                    if($isValid)
                    {
                        if(isset($validationMessages[$propertyName][ValidationDataAnnotationType::success]))
                        {
                            $validationMessagesResults[$propertyName] =
                                $validationMessages[$propertyName][ValidationDataAnnotationType::success];
                        }
                        else if(isset($validationMessages[ValidationDataAnnotationType::success]))
                        {
                            $validationMessagesResults[$propertyName] =
                                $validationMessages[ValidationDataAnnotationType::success];
                        }
                    }
                    else if(isset($validationMessages[$propertyName][ValidationDataAnnotationType::error]))
                    {
                        $validationMessagesResults[$propertyName] =
                            $validationMessages[$propertyName][ValidationDataAnnotationType::error];
                    }
                    else if(isset($validationMessages[ValidationDataAnnotationType::error]))
                    {
                        $validationMessagesResults[$propertyName] =
                            $validationMessages[ValidationDataAnnotationType::error];
                    }


                    break;
                }
            }
        }

        return $validationMessagesResults;
    }

    /**
     * @param $variableFieldValue
     * @param $validationAttributeConditions
     * @param $modelFieldsAndValues
     * @return array
     *
     * Checks if the value of a model's field is valid according to the validation properties/conditions set in the
     * viewModel constructor.
     */
    public function checkInputValidity($variableFieldValue, $validationAttributeConditions,
                                       $modelFieldsAndValues): array
    {
        $validationResults = array();

        if(!isset($variableFieldValue) || $variableFieldValue == '')
            return $validationResults;

        foreach($validationAttributeConditions as $attributeName => $attributeCondition)
        {
            foreach (ValidationDataAnnotationType::validationAttributes as $validationAttribute)
            {
                if ($attributeName == $validationAttribute)
                {
                    switch ($attributeName)
                    {
                        case ValidationDataAnnotationType::maxLength:
                            {
                                if (strlen($variableFieldValue) < $attributeCondition)
                                {
                                    $validationResults[$attributeName] = 1;
                                }
                                else
                                {
                                    $validationResults[$attributeName] = 0;
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::minLength:
                            {
                                if (strlen($variableFieldValue) > $attributeCondition)
                                {
                                    $validationResults[$attributeName] = 1;
                                }
                                else
                                {
                                    $validationResults[$attributeName] = 0;
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::symbols:
                            {
                                preg_match_all('/[$-/:-?{-~!"^_`\[\]]/', $variableFieldValue, $symbolCount);
                                if (count($symbolCount[0]) >= $attributeCondition)
                                {
                                    $validationResults[$attributeName] = 1;
                                }
                                else
                                {
                                    $validationResults[$attributeName] = 0;
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::required:
                            {
                                if (isset($variableFieldValue) && $variableFieldValue !== '')
                                {
                                    $validationResults[$attributeName] = 1;
                                }
                                else
                                {
                                    $validationResults[$attributeName] = 0;
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::equalTo:
                            {
                                $validationResults[$attributeName] = 0;

                                switch ($attributeCondition)
                                {
                                    case array_key_exists($attributeCondition, $modelFieldsAndValues):
                                            if($modelFieldsAndValues[$attributeCondition] === $variableFieldValue)
                                                $validationResults[$attributeName] = 1;
                                        break;

                                    default:
                                        if($attributeCondition === $variableFieldValue)
                                            $validationResults[$attributeName] = 1;
                                        break;
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::greaterThan:
                            {
                                $validationResults[$attributeName] = 0;

                                switch ($attributeCondition)
                                {
                                    case array_key_exists($attributeCondition, $modelFieldsAndValues):
                                        if($modelFieldsAndValues[$attributeCondition] > $variableFieldValue)
                                            $validationResults[$attributeName] = 1;
                                        break;

                                    default:
                                        if($attributeCondition > $variableFieldValue)
                                            $validationResults[$attributeName] = 1;
                                        break;
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::greaterThanEqual:
                            {
                                $validationResults[$attributeName] = 0;

                                switch ($attributeCondition)
                                {
                                    case array_key_exists($attributeCondition, $modelFieldsAndValues):
                                        if($modelFieldsAndValues[$attributeCondition] >= $variableFieldValue)
                                            $validationResults[$attributeName] = 1;
                                        break;

                                    default:
                                        if($attributeCondition >= $variableFieldValue)
                                            $validationResults[$attributeName] = 1;
                                        break;
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::lowerThanEqual:
                            {
                                $validationResults[$attributeName] = 0;

                                switch ($attributeCondition)
                                {
                                    case array_key_exists($attributeCondition, $modelFieldsAndValues):
                                        if($modelFieldsAndValues[$attributeCondition] <= $variableFieldValue)
                                            $validationResults[$attributeName] = 1;
                                        break;

                                    default:
                                        if($attributeCondition <= $variableFieldValue)
                                            $validationResults[$attributeName] = 1;
                                        break;
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::lowerThan:
                            {
                                $validationResults[$attributeName] = 0;

                                switch ($attributeCondition)
                                {
                                    case array_key_exists($attributeCondition, $modelFieldsAndValues):
                                        if($modelFieldsAndValues[$attributeCondition] < $variableFieldValue)
                                            $validationResults[$attributeName] = 1;
                                        break;

                                    default:
                                        if($attributeCondition < $variableFieldValue)
                                            $validationResults[$attributeName] = 1;
                                        break;
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::numerals:
                            {
                                preg_match_all('/[0-9]/', $variableFieldValue, $numeralCount);
                                if (count($numeralCount[0]) >= $attributeCondition)
                                {
                                    $validationResults[$attributeName] = 1;
                                }
                                else
                                    {
                                    $validationResults[$attributeName] = 0;
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::upperCharacters:
                            {
                                preg_match_all('/[A-Z]/', $variableFieldValue, $capitalCaseCount);

                                if (count($capitalCaseCount[0]) >= $attributeCondition)
                                {
                                    $validationResults[$attributeName] = 1;
                                }
                                else
                                {
                                    $validationResults[$attributeName] = 0;
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::lowerCharacters:
                            {
                                preg_match_all('/[a-z]/', $variableFieldValue, $lowerCaseCount);

                                if (count($lowerCaseCount[0]) >= $attributeCondition)
                                {
                                    $validationResults[$attributeName] = 1;
                                }
                                else
                                {
                                    $validationResults[$attributeName] = 0;
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::dateFormat:
                            {
                                if (DateTime::createFromFormat($attributeCondition,
                                                               $variableFieldValue) !== false)
                                {
                                    $validationResults[$attributeName] = 1;
                                }
                                else
                                {
                                    $validationResults[$attributeName] = 0;
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::dateAfter:
                            {
                                $validationResults[$attributeName] = 0;

                                if (strtotime($variableFieldValue))
                                {
                                    try
                                    {
                                        if(isset($validationAttributeConditions[ValidationDataAnnotationType::dateFormat]))
                                        {
                                            if (date_format(new DateTime($variableFieldValue),
                                                            $validationAttributeConditions[ValidationDataAnnotationType::dateFormat]) >
                                                date_format(new DateTime($attributeCondition),
                                                            $validationAttributeConditions[ValidationDataAnnotationType::dateFormat]))
                                            {
                                                $validationResults[$attributeName] = 1;
                                            }
                                        }
                                        else if (date_format(new DateTime($variableFieldValue),
                                                             WebConfig::DEFAULT_DATETIME_FORMAT) >
                                            date_format(new DateTime($attributeCondition),
                                                        WebConfig::DEFAULT_DATETIME_FORMAT))
                                        {
                                            $validationResults[$attributeName] = 1;
                                        }
                                    }
                                    catch (\Exception $exception)
                                    {
                                        Error::log(ErrorLogType::webError, $exception);
                                    }
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::dateBefore;
                            {
                                $validationResults[$attributeName] = 0;

                                if (strtotime($variableFieldValue))
                                {
                                    try
                                    {
                                        if(isset($validationAttributeConditions[ValidationDataAnnotationType::dateFormat]))
                                        {
                                            if (date_format(new DateTime($variableFieldValue),
                                                            $validationAttributeConditions[ValidationDataAnnotationType::dateFormat]) <
                                                date_format(new DateTime($attributeCondition),
                                                            $validationAttributeConditions[ValidationDataAnnotationType::dateFormat]))
                                            {
                                                $validationResults[$attributeName] = 1;
                                            }
                                        }
                                        else if (date_format(new DateTime($variableFieldValue),
                                                        WebConfig::DEFAULT_DATETIME_FORMAT) <
                                            date_format(new DateTime($attributeCondition),
                                                        WebConfig::DEFAULT_DATETIME_FORMAT))
                                        {
                                            $validationResults[$attributeName] = 1;
                                        }
                                    }
                                    catch (\Exception $exception)
                                    {
                                        Error::log(ErrorLogType::webError, $exception);
                                    }
                                }
                            }
                            break;

                        case ValidationDataAnnotationType::dataType:
                            {
                                switch ($attributeCondition)
                                {
                                    case ValidationDataType::email:
                                        if (filter_var($variableFieldValue, FILTER_VALIDATE_EMAIL))
                                        {
                                            $validationResults[$attributeName] = 1;
                                        }
                                        else
                                        {
                                            $validationResults[$attributeName] = 0;
                                        }
                                        break;

                                    case ValidationDataType::phoneNumber:
                                        if (preg_match('/^[0-9]{10}+$/', $variableFieldValue))
                                        {
                                            $validationResults[$attributeName] = 1;
                                        }
                                        else
                                        {
                                            $validationResults[$attributeName] = 0;
                                        }
                                        break;
                                }
                            }
                            break;

                        default:
                            break;
                    }
                    break;
                }
            }
        }

        return $validationResults;
    }

    /**
     * @param ValidationModelData $validationModelData
     * @return bool
     * Determines the validity of the ViewModel based on the conditions set for its fields.
     * @throws \Exception
     */
    public function isValid(ValidationModelData $validationModelData): bool
    {
        $isValid = true;

        $propertiesValidationResults = array();
        $messageValidationResults = array();

        $validationStatusResults = array();

        foreach ($validationModelData->getValidationFields() as $fieldName => $fieldValue)
        {
            $properties = $validationModelData->getValidationFieldProperties($fieldName);
            $extractedPropertyConditions = $this->extractValidationConditions($properties);

            if (!empty($properties))
            {
                /**
                 * validate the field against its conditions, creates a list of bools
                 */
                $propertiesValidationResults[$fieldName] =
                    $this->checkInputValidity($fieldValue, $extractedPropertyConditions,
                                              $validationModelData->getValidationFields());

                $messages = $validationModelData->getValidationFieldMessage($fieldName);

                $messageValidationResults[$fieldName] =
                    $this->buildErrorMessageForField($fieldName,
                                                     $extractedPropertyConditions,
                                                     $propertiesValidationResults[$fieldName],
                                                     $messages,
                                                     $validationModelData->getValidationFields()
                    );
            }

            foreach ($propertiesValidationResults[$fieldName] as $property => $isPropertyValid)
            {
                if ($isPropertyValid)
                {

                    $validationStatusResults[$fieldName] = new ValidationStatus(ValidationDataAnnotationType::success,
                        $messageValidationResults[$fieldName][$property]);
                }
                else
                {
                    /**
                     * if there is an invalid field then we stop as we have the error message
                     */
                    $validationStatusResults[$fieldName] = new ValidationStatus(ValidationDataAnnotationType::error,
                                                                                $messageValidationResults[$fieldName][$property]);

                    $isValid = false;

                    break;
                }
            }
        }

        $validationModelData->setValidationFieldStatus($validationStatusResults);


        return $isValid;
    }
}
