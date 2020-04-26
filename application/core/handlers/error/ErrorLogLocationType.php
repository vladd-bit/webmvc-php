<?php

namespace Application\Core\Handlers\Error;

abstract class ErrorLogLocationType extends \SplEnum
{
    const __default = self::logDirectory;

    const logDirectory = 0;
    const dbLog = 1;
}