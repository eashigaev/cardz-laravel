<?php

namespace Codderz\YokoLite\Tests\Support;

use Codderz\YokoLite\Shared\Macros\EventMacros;
use Illuminate\Support\Facades\Event;

trait EventTestTrait
{
    public function mixinEvent()
    {
        Event::mixin(new EventMacros());
    }

    public function flushEventListeners(array $except = [])
    {
        Event::flushClassListeners($except);
    }
}
