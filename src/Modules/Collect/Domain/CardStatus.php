<?php

namespace CardzApp\Modules\Collect\Domain;

use Codderz\YokoLite\Shared\Utils\EnumTrait;

enum CardStatus: int
{
    use EnumTrait;

    case ACTIVE = 0;
    case CANCELLED = 40;
    case REJECTED = 50;
    case REWARDED = 100;
}
