<?php

namespace Codderz\YokoLite\Domain\Uuid;

use function app;

trait UuidTestTrait
{
    public function uuidGenerator(): UuidGenerator
    {
        return app()->make(UuidGenerator::class);
    }
}
