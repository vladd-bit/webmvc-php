<?php

namespace Application\Core;

use Application\Config\WebConfig;

class Error
{
    public static function log($errorType, \Exception $exception)
    {
        $dbLogFilePath = LOGS_FOLDER.'\\';
        $timestamp = date('Y-m-d H:i:s');

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
            fwrite($file, "\n"."========================================================================================================================================================================================================================================================================================================================================================"."\n".$timestamp."\n".$exception."\n");
        }
        else
        {
            $file = fopen($dbLogFilePath, 'w');
            fwrite($file, "\n"."========================================================================================================================================================================================================================================================================================================================================================"."\n".$timestamp."\n".$exception."\n");
        }

        http_response_code(404);
        die();
    }
}
