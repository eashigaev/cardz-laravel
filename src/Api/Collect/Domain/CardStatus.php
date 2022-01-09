<?php

namespace CardzApp\Api\Collect\Domain;

enum CardStatus: int
{
    case ACTIVE = 0;
    case INACTIVE = 10;
    case CANCELLED = 50;
    case REJECTED = 70;
    case REWARDED = 100;
}
