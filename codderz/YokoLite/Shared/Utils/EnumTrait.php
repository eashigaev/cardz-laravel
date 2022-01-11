<?php

namespace Codderz\YokoLite\Shared\Utils;

trait EnumTrait
{
    public function is(int $value)
    {
        return self::from($value)->value === $this->value;
    }
}
