<?php

namespace CardzApp\Api\Shared\Presentation;

use Codderz\YokoLite\Presentation\AuthUserTrait;
use Codderz\YokoLite\Presentation\JsonPresenterTrait;

trait ControllerTrait
{
    use JsonPresenterTrait;
    use AuthUserTrait;
}
