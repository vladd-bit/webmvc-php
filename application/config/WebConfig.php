<?php

namespace Application\Config;

class WebConfig
{
    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;

    const DB_ERROR_LOG_FILENAME = 'dblog.log';

    const WEB_ERROR_LOG_FILENAME = 'weblog.log';

    /**
     * Store namespace paths for easier use in the application.
     */
    const CONTROLLER_NAMESPACE = 'Application\Controllers\\';
    const CORE_NAMESPACE = 'Application\Core\\';
    const MODEL_NAMESPACE = 'Application\Models\\';
    const VIEW_NAMESPACE = 'Application\Views\\';

    const PROJECT_NAME = 'WebWay';

    const HTTPS_ENABLED = false;

    /**
     * used for URL redirection ONLY
     * leave empty if the website is not located in a subfolder , for example on linux var/www/ or on windows C:/nginx/www/
     * if the website IS located in a subfolder for example on linux var/www/website_one/ or on windows C:/nginx/www/website_one/ then modify the value to /website_one
     * please note that you will need properly configured nginx REWRITE RULES for subfolders
     */

    static $HTTP_URL_STRING = self::HTTPS_ENABLED ? 'https://' : 'http://';

    const DEFAULT_SESSION_LIFETIME = 36000; // lifetime in seconds for user login sessions.

    /**
     * GLOBAL DATETIME FORMAT
     * used for date conversion as a standard.
     * default Y-m-d G:i:s  (year-month-day hours:seconds:milliseconds)
     */
    const DEFAULT_DATETIME_FORMAT = 'Y-m-d G:i:s';

    const DEFAULT_LOCALE_CONFIGURATION = array('en_GB.UTF8','en_GB@euro','en_GB','english');

    const DEFAULT_TIMEZONE = 'Europe/London';


    /**
     * Website folder paths
     */
    const VIEWS_DIRECTORY = DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR;

    const WEBSITE_PATH = DIRECTORY_SEPARATOR.'website';

    const LOGS_FOLDER_NAME = DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR;

    /**
     * FOLDER/FILE creation permissions
     */

    const DEFAULT_FOLDER_CREATION_PERMISSIONS = 0755;

    /**
     * PHP SESSION SETTINGS, DO NOT MODIFY UNLESS YOU INTEND TO MODIFY THE SESSION STORAGE PATH OR THE DEFAULT PHP SESSION NAME.
     * the session storage path will always be within the project's current folder.
     */

    const MODIFY_SESSION_STORAGE_PATH = false;
    const SESSION_STORAGE_PATH = DIRECTORY_SEPARATOR.'sessions'.DIRECTORY_SEPARATOR;
    const SESSION_NAME = 'instance';
}
