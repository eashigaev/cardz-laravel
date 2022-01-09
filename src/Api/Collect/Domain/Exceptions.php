<?php

namespace CardzApp\Api\Collect\Domain;

use Codderz\YokoLite\Shared\Exception;

class Exceptions
{
    public static function programIsNotActive()
    {
        return Exception::of('Program is not active');
    }
}
