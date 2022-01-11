<?php

namespace Codderz\YokoLite\Shared\Utils;

trait EnumTrait
{
    public function is($value)
    {
        return $value === $this || self::tryFrom($value) === $this;
    }
}
