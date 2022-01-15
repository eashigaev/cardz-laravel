<?php

namespace Codderz\YokoLite\Infrastructure\Registry;

class SimpleRegistry implements Registry
{
    private array $items = [];

    public function get(string $index, mixed $default = null)
    {
        return $this->items[$index] ?? $default;
    }

    public function set(string $index, mixed $value)
    {
        $this->items[$index] = $value;
    }

    public function unset(string $index, mixed $default = null)
    {
        $value = $this->get($index, $default);
        unset($this->items[$index]);
        return $value;
    }

    public function has(string $index)
    {
        return array_key_exists($index, $this->items);
    }
}
