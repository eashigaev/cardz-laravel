<?php

namespace CardzApp\Modules\Collect\Domain;

abstract class Messages
{
    const INVALID_ARGUMENT = 'Invalid argument';
    const NOT_FOUND = 'Not found';
    const PROGRAM_IS_NOT_ACTIVE = 'Program is not active';
    const PROGRAM_TARGET_ALREADY_REACHED = 'Program target already reached';
    const TASK_IS_NOT_ACTIVE = 'Task is not active';
    const CARD_IS_NOT_ACTIVE = 'Card is not active';
    const CARD_BALANCE_IS_NOT_ENOUGH = 'Card balance is not enough';
    const CARD_TASK_ALREADY_ACHIEVED = 'Card task already achieved';
}
