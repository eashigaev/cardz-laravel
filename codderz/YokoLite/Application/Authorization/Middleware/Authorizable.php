<?php

namespace Codderz\YokoLite\Application\Authorization\Middleware;

interface Authorizable
{
    public static function authorizableOrFail($id);
}
