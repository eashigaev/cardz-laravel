<?php

namespace CardzApp\Api\Shared;

use CardzApp\Modules\Shared\Application\Actions;
use Codderz\YokoLite\Application\Authentication\Authentication;

abstract class Routes extends Actions
{
    const URL_PREFIX = '/api/v1';

    const API_MIDDLEWARE = 'api';
    const AUTHENTICATE_MIDDLEWARE = Authentication::MIDDLEWARE;
}
