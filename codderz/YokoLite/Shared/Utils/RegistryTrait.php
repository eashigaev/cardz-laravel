<?php

namespace Codderz\YokoLite\Shared\Utils;

trait RegistryTrait
{
    private $registry = [];

    public function getRegistry(string $index, mixed $default = null)
    {
        return $this->registry[$index] ?? $default;
    }

    public function setRegistry(string $index, mixed $default)
    {
        $this->registry[$index] = $default;
    }
}
