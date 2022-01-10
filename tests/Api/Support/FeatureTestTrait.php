<?php

namespace Tests\Api\Support;

use Codderz\YokoLite\Application\Authentication\SanctumTestTrait;
use Codderz\YokoLite\Application\Authorization\GateTestTrait;
use Codderz\YokoLite\Tests\Support\EventTestTrait;
use Codderz\YokoLite\Tests\Support\ExceptionTestTrait;
use Codderz\YokoLite\Tests\Support\HttpTestTrait;
use Codderz\YokoLite\Tests\Support\PhpUnitTestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;

trait FeatureTestTrait
{
    use RefreshDatabase;
    use PhpUnitTestTrait;
    use HttpTestTrait;
    use ExceptionTestTrait;
    use SanctumTestTrait;
    use GateTestTrait;
    use EventTestTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->mixinEvent();
    }
}
