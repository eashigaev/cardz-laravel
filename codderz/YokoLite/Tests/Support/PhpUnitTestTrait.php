<?php

namespace Codderz\YokoLite\Tests\Support;

use Throwable;

trait PhpUnitTestTrait
{
    public function expectThrowable()
    {
        $this->expectException(Throwable::class);
    }

    public function assertThrowable(callable $callback, object|string $exception)
    {
        try {
            $callback();
        } catch (Throwable $actual) {
            $this->assertEquals(is_object($exception) ? $actual : $actual::class, $exception);
            return;
        }
        $this->fail("Throwable $exception was not thrown");
    }

    //

    public function assertArraySubset(array $subset, array $array)
    {
        $this->assertEquals(array_replace_recursive($array, $subset), $array);
    }

    public function assertArrayHasKeys(array $keys, array $array)
    {
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $array);
        }
    }

    public function assertArrayNotHasKeys(array $keys, array $array)
    {
        foreach ($keys as $key) {
            $this->assertArrayNotHasKey($key, $array);
        }
    }

    //

    public function matchArrayPattern(string $pattern, array $array): bool
    {
        foreach ($array as $string) {
            if (!preg_match($pattern, $string)) continue;
            return true;
        }
        return false;
    }

    public function assertArrayMatches(string $pattern, array $array)
    {
        $this->assertTrue($this->matchArrayPattern($pattern, $array));
    }

    public function assertArrayNotMatches(string $pattern, array $array)
    {
        $this->assertFalse($this->matchArrayPattern($pattern, $array));
    }
}
