<?php

namespace CardzApp\Api\Presentation;

use Codderz\YokoLite\Presentation\AuthUserTrait;
use Codderz\YokoLite\Presentation\JsonPresenterTrait;

trait ControllerTrait
{
    use JsonPresenterTrait;
    use AuthUserTrait;
}
