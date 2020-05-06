<?php

namespace Application\Core;

abstract class ValidationDataAnnotationType extends \SplEnum
{
    const __default = 'none';

    const maxLength = 'maxLength';
    const minLength = 'minLength';
    const required = 'required';
    const optional = 'optional';
    const numerals = 'numerals';
    const symbols = 'symbols';
    const error = 'error';
    const success = 'success';
    const displayFormat = 'displayFormat';
    const lowerCharacters = 'lowerCharacters';
    const upperCharacters = 'upperCharacters';
    const dateFormat = 'dateFormat';
    const dateAfter = 'dateAfter';
    const dateBefore = 'dateBefore';
    const dataType = 'dataType';
    const equalTo = 'equalTo';
    const greaterThan = 'greaterThan';
    const greaterThanEqual = 'greaterThanEqual';
    const lowerThanEqual = 'lowerThanEqual';
    const lowerThan = 'lowerThan';
    const validationAttributes = ['maxLength','minLength','required','optional', 'numerals',
                                  'lowerCharacters','upperCharacters','dataType', 'dateFormat',
                                  'dateAfter', 'dateBefore','equalTo', 'greaterThan', 'lowerThan', 'greaterThanEqual',
                                  'lowerThanEqual'];
    const validationDataTypes = [ 'email', 'password'];
    const validationMessageType = 'messageType';
    const validationMessageStatus = ['error' => 'error', 'success' => 'success'];
    const validationMessage = ['error' => 'error', 'success' => 'success'];
    const validationMessageContent = 'content';
}

