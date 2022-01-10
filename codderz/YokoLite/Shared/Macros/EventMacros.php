<?php

namespace Codderz\YokoLite\Shared\Macros;

use Closure;
use Illuminate\Support\Arr;
use Laravel\SerializableClosure\Support\ReflectionClosure;

class EventMacros
{
    public function flushClassListeners(array $except = [])
    {
        return function (array $except): void {
            foreach ($this->listeners as $eventName => $eventListeners) {
                foreach ($eventListeners as $closureIndex => $closure) {
                    $reflection = new ReflectionClosure($closure);
                    $reflection = $reflection->getUseVariables();
                    $inner = Arr::get($reflection, 'listener');
                    if ($inner === null || $inner instanceof Closure || in_array($inner, $except)) {
                        continue;
                    }
                    if (is_array($inner) && in_array($inner[0], $except)) {
                        continue;
                    }
                    unset($this->listeners[$eventName][$closureIndex]);
                }
            }
        };
    }
}
