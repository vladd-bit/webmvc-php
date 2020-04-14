<?php

namespace Application\Core;

abstract class ErrorDatabaseQueryType extends \SplEnum
{
    const __default = self::FailedQuery;

    const FailedQuery = -1;
    const DuplicateEntry = 0;
    const SuccessfulExecution = 1;
}