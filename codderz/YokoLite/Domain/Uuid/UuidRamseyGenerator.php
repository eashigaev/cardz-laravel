<?php

namespace Codderz\YokoLite\Domain\Uuid;

use Ramsey\Uuid\Uuid as RamseyUuid;

class UuidRamseyGenerator implements UuidGenerator
{
    public function getNextValue(): string
    {
        return RamseyUuid::uuid4()->toString();
    }
}
