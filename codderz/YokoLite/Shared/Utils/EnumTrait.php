<?php

namespace Codderz\YokoLite\Shared\Utils;

trait EnumTrait
{
    public function is($value)
    {
        return self::from($value) === $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getName()
    {
        return $this->name;
    }
}
