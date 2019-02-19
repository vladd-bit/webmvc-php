<?php

namespace Application\Core;

abstract class DbError
{
    const FailedQuery = -1;
    const DuplicateEntry = 0;
    const SuccessfulExecution = 1;
}