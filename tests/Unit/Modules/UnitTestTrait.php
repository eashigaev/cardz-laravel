<?php

namespace Tests\Unit\Modules;

use Codderz\YokoLite\Domain\Uuid\UuidTestTrait;
use Codderz\YokoLite\Tests\Support\PhpUnitTestTrait;

trait UnitTestTrait
{
    use PhpUnitTestTrait,
        UuidTestTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }
}
