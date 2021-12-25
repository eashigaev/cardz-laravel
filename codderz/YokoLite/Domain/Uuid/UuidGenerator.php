<?php

namespace Codderz\YokoLite\Domain\Uuid;

interface UuidGenerator
{
    public function getNextValue(): string;
}
