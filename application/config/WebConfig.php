<?php

namespace Application\Config;

class WebConfig
{
    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;

    const DB_ERROR_LOG_FILENAME = 'dblog.txt';

    const WEB_ERROR_LOG_FILENAME = 'weblog.txt';

    /**
     * Store namespace paths for easier use in the application.
     */
    const CONTROLLER_NAMESPACE = 'Application\Controllers\\';
    const CORE_NAMESPACE = 'Application\Core\\';
    const MODEL_NAMESPACE = 'Application\Models\\';
    const VIEW_NAMESPACE = 'Application\Views\\';

    const VIEWS_DIRECTORY = '/views/';

    const PROJECT_NAME = 'WebWay';

    const HTTPS_ENABLED = false;

    /**
     * used for URL redirection ONLY
     * leave empty if the website is not located in a subfolder , for example on linux var/www/ or on windows C:/nginx/www/
     * if the website IS located in a subfolder for example on linux var/www/website_one/ or on windows C:/nginx/www/website_one/ then modify the value to /website_one
     * please note that you will need properly configured nginx REWRITE RULES for subfolders
     */
    const WEBSITE_PATH = '/website';

    static $HTTP_URL_STRING = self::HTTPS_ENABLED ? 'https://' : 'http://';

    const DEFAULT_SESSION_LIFETIME = 36000; // lifetime in seconds for user login sessions.


    /**
     * Website folder paths
     */

    const LOGS_FOLDER = __DIR__.'/logs';

    /**
     * PHP SESSION SETTINGS, DO NOT MODIFY UNLESS YOU INTEND TO MODIFY THE SESSION STORAGE PATH OR THE DEFAULT PHP SESSION NAME.
     * the session storage path will always be within the project's current folder.
     */

    const MODIFY_SESSION_STORAGE_PATH = false;
    const SESSION_STORAGE_PATH = '/sessions';
    const SESSION_NAME = 'instance';
}
