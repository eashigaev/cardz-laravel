<?php

namespace Codderz\YokoLite\Shared\Utils;

use ReflectionClass;

class Reflect
{
    public static function getShortClass($class)
    {
        return (new ReflectionClass($class))->getShortName();
    }
}
