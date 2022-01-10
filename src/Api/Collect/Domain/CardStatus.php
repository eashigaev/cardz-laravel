<?php

namespace CardzApp\Api\Collect\Domain;

enum CardStatus: int
{
    case ACTIVE = 0;
    case CANCELLED = 40;
    case REJECTED = 50;
    case REWARDED = 100;
}
