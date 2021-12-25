<?php

namespace Codderz\YokoLite\Domain\Uuid;

class Uuid
{
    private string $value;

    public function isEquals(self $id)
    {
        return $this->getValue() === $id->getValue();
    }

    public function getValue()
    {
        return $this->value;
    }

    public static function of(string $value)
    {
        $self = new self;
        $self->value = $value;
        return $self;
    }
}
