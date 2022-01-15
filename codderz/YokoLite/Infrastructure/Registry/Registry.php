<?php

namespace Codderz\YokoLite\Infrastructure\Registry;

interface Registry
{
    public function get(string $index, mixed $default = null);

    public function set(string $index, mixed $value);

    public function unset(string $index);

    public function has(string $index);
}
