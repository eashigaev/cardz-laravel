<?php

namespace Codderz\YokoLite\Application\Auth;

abstract class Auth
{
    public const CAN_MIDDLEWARE = 'can';
    public const SANCTUM_MIDDLEWARE = 'auth:sanctum';
}
