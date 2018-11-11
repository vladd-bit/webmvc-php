<?php

namespace Application\Core;

use Application\Config\WebConfig;

class Error
{
    public static function log($errorType, \Exception $exception)
    {
        $dbLogFilePath = LOGS_FOLDER;

        if (!file_exists(LOGS_FOLDER))
        {
            mkdir(LOGS_FOLDER, WebConfig::DEFAULT_FOLDER_CREATION_PERMISSIONS, true);
        }

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

        $errorContent = "\n"."==================================================================================================================================================================================================================================================================================================="
                        ."\n".$timestamp."\n".$exception."\n";

        if(file_exists($dbLogFilePath))
        {
            $file = fopen($dbLogFilePath, 'a');
        }
        else
        {
            $file = fopen($dbLogFilePath, 'w');
        }

        fwrite($file, $errorContent);
        fclose($file);

        http_response_code(404);
        die();
    }
}
