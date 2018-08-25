<?php

namespace Application\Core;

use Application\Config\WebConfig;

class Error
{
    public static function log($errorType, $errorLogLocationType = 0, \Exception $exception)
    {
        $dbLogFilePath = LOGS_FOLDER.'\\';
        switch ($errorType)
        {
            case ErrorLogType::dbError:
                $dbLogFilePath = $dbLogFilePath.WebConfig::DB_ERROR_LOG_FILENAME;
                break;
            case ErrorLogType::webError:
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
