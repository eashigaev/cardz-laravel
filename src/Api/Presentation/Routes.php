<?php

namespace CardzApp\Api\Presentation;

use CardzApp\Api\Application\Actions;
use Codderz\YokoLite\Application\Auth\Auth;

abstract class Routes extends Actions
{
    const URL_PREFIX = '/api/v1';

    const API_MIDDLEWARE = 'api';
    const AUTHENTICATE_MIDDLEWARE = Auth::SANCTUM_MIDDLEWARE;
    const AUTHORIZE_MIDDLEWARE = Auth::CAN_MIDDLEWARE;
}
