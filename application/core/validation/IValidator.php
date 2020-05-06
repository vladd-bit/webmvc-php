<?php

namespace Application\Core\Validation;


interface IValidator
{
    function extractValidationConditions($conditions): array;
    function buildErrorMessageForField($fieldName, $validationPropertyConditions,
                                              $validationPropertyResults, $validationMessages, $modelFieldsAndValues): array;
    function checkInputValidity($variableFieldValue, $validationAttributeConditions, $modelFieldsAndValues): array;
    function isValid(ValidationModelData $validationModelData) : bool;

}