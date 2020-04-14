<?php

namespace Application\Core;

abstract class ErrorLogLocationType extends \SplEnum
{
    const __default = self::logDirectory;

    const logDirectory = 0;
    const dbLog = 1;
}