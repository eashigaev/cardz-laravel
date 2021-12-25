<?php

namespace Codderz\YokoLite\Tests\Support;

use Codderz\YokoLite\Shared\Exception;

trait ContainerTestTrait
{
    public function setUpMock(string $contract, bool $exists = true)
    {
        if ($exists && !app()->bound($contract)) {
            throw Exception::of('Contract not found');
        }

        $mock = $this->createMock($contract);
        app()->instance($contract, $mock);
        return $mock;
    }
}
