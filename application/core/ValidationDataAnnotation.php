<?php

namespace Application\Core;

abstract class ValidationDataAnnotation
{
    const maxLength = 'maxLength';
    const minLength = 'minLength';
    const required = 'required';
    const optional = 'optional';
    const error = 'error';
    const success = 'success';
    const displayFormat = 'displayFormat';
    const lowerCharacters = 'lowerCharacters';
    const upperCharacters = 'upperCharacters';
    const dataType = 'dataType';
    const validationAttributes = ['maxLength','minLength','required','optional','lowerCharacters','upperCharacters','dataType'];
    const validationDataTypes = ['datetime', 'email', 'password'];
    const validationMessageType = 'messageType';
    const validationMessageStatus = ['error' => 'error', 'success' => 'success'];
    const validationMessage = ['error' => 'error', 'success' => 'success'];
    const validationMessageContent = 'content';
}

