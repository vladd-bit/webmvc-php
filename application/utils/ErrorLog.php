<?php

namespace Application\Utils;

use Application\Config\WebConfig;

abstract class ErrorLogTypes
{
    const dbError = 0;
    const webError = 1;
}

class ErrorLog
{
    public static function logError($errorType, \Exception $exception)
    {
        $dbLogFilePath = LOGS_FOLDER.'\\';
        switch ($errorType)
        {
            case 0:
                $dbLogFilePath = $dbLogFilePath.WebConfig::DB_ERROR_LOG_FILENAME;
                break;
            case 1:
                $dbLogFilePath = $dbLogFilePath.WebConfig::WEB_ERROR_LOG_FILENAME;
                break;
        }

        if(file_exists($dbLogFilePath))
        {
            $file = fopen($dbLogFilePath, 'a');
            fwrite($file, "\n".$exception);
        }
        else
        {
            $file = fopen($dbLogFilePath, 'w');
            fwrite($file, "\n".$exception);
        }

        http_response_code(404);
        die();
    }
}