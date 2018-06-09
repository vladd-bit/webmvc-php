<?php

namespace Application\Config;

class WebConfig
{
    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;

    /**
     * Store namespace paths for easier use in the application.
     */
    const CONTROLLER_NAMESPACE = 'Application\Controllers\\';
    const CORE_NAMESPACE = 'Application\Core\\';
    const MODEL_NAMESPACE = 'Application\Models\\';
    const VIEW_NAMESPACE = 'Application\Views\\';

    const VIEWS_DIRECTORY = '/views/';

    const PROJECT_NAME = "website";
}
