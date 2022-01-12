<?php

namespace Tests\Modules\Support;

use Codderz\YokoLite\Tests\Support\ExceptionTestTrait;
use Codderz\YokoLite\Tests\Support\PhpUnitTestTrait;

trait UnitTestTrait
{
    use PhpUnitTestTrait;
    use ExceptionTestTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }
}
