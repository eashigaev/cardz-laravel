<?php

namespace CardzApp\Api\Tests\Support;

use Codderz\YokoLite\Application\Authentication\SanctumTestTrait;
use Codderz\YokoLite\Application\Authorization\GateTestTrait;
use Codderz\YokoLite\Tests\Support\ExceptionTestTrait;
use Codderz\YokoLite\Tests\Support\HttpTestTrait;
use Codderz\YokoLite\Tests\Support\PhpUnitTestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;

trait ModuleTestTrait
{
    use RefreshDatabase;
    use PhpUnitTestTrait;
    use HttpTestTrait;
    use ExceptionTestTrait;
    use SanctumTestTrait;
    use GateTestTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }
}
