<?php

namespace Codderz\YokoLite\Shared\Utils;

class Func
{
    public static function identity(): callable
    {
        return fn($_) => $_;
    }
}
