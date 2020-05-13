<?php

namespace Application\Core\Handlers\Error;

use PDOException;

class ErrorExceptionHandler
{
    public static function handleException(\Throwable $exception)
    {
        if ($exception instanceof PDOException)
        {
            Error::log(ErrorLogType::dbError, $exception);
        }
        else
        {
            Error::log(ErrorLogType::webError, $exception);
        }
    }
}
