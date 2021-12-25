<?php

namespace Codderz\YokoLite\Tests\Support;

use Carbon\Carbon;

trait CarbonTestTrait
{
    public function mockDate(Carbon $date): Carbon
    {
        Carbon::setTestNow($date);
        return $date;
    }
}
