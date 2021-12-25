<?php

namespace Codderz\YokoLite\Shared\Utils;

class Json
{
    public static function to(array $data = []): string
    {
        return json_encode($data);
    }

    public static function from(string $content, bool $assoc = true): array
    {
        return json_decode($content, $assoc) ?? [];
    }

    public static function error(): bool
    {
        return json_last_error() !== JSON_ERROR_NONE;
    }
}
