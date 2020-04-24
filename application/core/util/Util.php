<?php

namespace Application\Core;

abstract class Util
{
    public static function cleanUrlPath($url)
    {
        return preg_replace('#/+#','/',$url);
    }
}