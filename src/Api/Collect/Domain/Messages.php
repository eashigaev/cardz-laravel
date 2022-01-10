<?php

namespace CardzApp\Api\Collect\Domain;

abstract class Messages
{
    const PROGRAM_IS_NOT_ACTIVE = 'Program must be active';
    const TASK_IS_NOT_ACTIVE = 'Program task must be active';
    const CARD_IS_NOT_ACTIVE = 'Card must be active';
    const CARD_BALANCE_IS_NOT_ENOUGH = 'Card balance is not enough';
    const ACHIEVEMENT_ALREADY_EXISTS = 'Card task already completed';
}
