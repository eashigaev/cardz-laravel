<?php

namespace CardzApp\Modules\Collect\Domain;

use Codderz\YokoLite\Domain\Uuid\Uuid;
use Codderz\YokoLite\Shared\Exception;
use Illuminate\Support\Collection;

class AchievementAggregate
{
    public Uuid $id;
    public Uuid $companyId;
    public Uuid $programId;
    public Uuid $taskId;
    public Uuid $cardId;

    public static function add(
        Uuid $id, ProgramAggregate $program, TaskAggregate $task, CardAggregate $card, Collection $achievedTaskIds
    )
    {
        if ($card->status !== CardStatus::ACTIVE) {
            throw Exception::of(Messages::CARD_IS_NOT_ACTIVE);
        }
        if (!$program->active) {
            throw Exception::of(Messages::PROGRAM_IS_NOT_ACTIVE);
        }
        if ($program->isRewardReached($card->balance)) {
            throw Exception::of(Messages::PROGRAM_TARGET_ALREADY_REACHED);
        }
        if (!$task->active) {
            throw Exception::of(Messages::TASK_IS_NOT_ACTIVE);
        }
        if ($task->isAlreadyAchieved($achievedTaskIds)) {
            throw Exception::of(Messages::ACHIEVEMENT_ALREADY_EXISTS);
        }

        return self::of($id, $program->companyId, $program->id, $task->id, $card->id);
    }

    public function remove(CardAggregate $card)
    {
        if ($card->status !== CardStatus::ACTIVE) {
            throw Exception::of(Messages::CARD_IS_NOT_ACTIVE);
        }
    }

    //

    public static function of(Uuid $id, Uuid $companyId, Uuid $programId, Uuid $taskId, Uuid $cardId)
    {
        $self = new self();
        $self->id = $id;
        $self->companyId = $companyId;
        $self->programId = $programId;
        $self->taskId = $taskId;
        $self->cardId = $cardId;
        return $self;
    }
}
