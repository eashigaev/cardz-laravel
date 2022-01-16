<?php

namespace Codderz\YokoLite\Tests\Support;

use ErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait ExceptionTestTrait
{
    public function expectNotFoundException()
    {
        $this->expectException(ModelNotFoundException::class);
    }

    public function expectErrorException()
    {
        $this->expectException(ErrorException::class);
    }
}
