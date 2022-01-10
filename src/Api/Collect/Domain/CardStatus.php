<?php

namespace CardzApp\Api\Collect\Domain;

enum CardStatus: int
{
    case INACTIVE = 0;
    case ACTIVE = 10;
    case CANCELLED = 40;
    case REJECTED = 50;
    case REWARDED = 100;
}
