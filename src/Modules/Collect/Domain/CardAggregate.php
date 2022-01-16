<?php

namespace CardzApp\Modules\Collect\Domain;

use Codderz\YokoLite\Domain\Uuid\Uuid;
use Codderz\YokoLite\Shared\Exception;
use Illuminate\Support\Collection;

class CardAggregate
{
    public Uuid $id;
    public Uuid $companyId;
    public Uuid $programId;
    public Uuid $holderId;
    public string $comment;

    public CardStatus $status;
    public Collection $achievements;

    public static function issue(Uuid $id, ProgramAggregate $program, Uuid $holderId, string $comment)
    {
        if (!$program->active) {
            throw Exception::of(Messages::PROGRAM_IS_NOT_ACTIVE);
        }

        $status = CardStatus::ACTIVE;
        $achievements = Collection::make();

        return self::of(
            $id, $program->companyId, $program->id, $holderId, $comment, $status, $achievements
        );
    }

    public function update(string $comment)
    {
        $this->comment = $comment;
    }

    public function reward(ProgramAggregate $program)
    {
        if (!$this->programId->isEquals($program->id)) {
            throw Exception::of(Messages::INVALID_ARGUMENT);
        }
        if ($this->status !== CardStatus::ACTIVE) {
            throw Exception::of(Messages::CARD_IS_NOT_ACTIVE);
        }
        if (!$program->active) {
            throw Exception::of(Messages::PROGRAM_IS_NOT_ACTIVE);
        }
        if ($this->getBalance() < $program->reward->getTarget()) {
            throw Exception::of(Messages::CARD_BALANCE_IS_NOT_ENOUGH);
        }

        $this->status = CardStatus::REWARDED;
    }

    public function reject()
    {
        if ($this->status !== CardStatus::ACTIVE) {
            throw Exception::of(Messages::CARD_IS_NOT_ACTIVE);
        }

        $this->status = CardStatus::REJECTED;
    }

    public function cancel()
    {
        if ($this->status !== CardStatus::ACTIVE) {
            throw Exception::of(Messages::CARD_IS_NOT_ACTIVE);
        }

        $this->status = CardStatus::CANCELLED;
    }

    //

    public function getBalance()
    {
        return $this->achievements->count();
    }

    //

    public function findAchievement(callable $criteria): AchievementEntity|null
    {
        return $this->achievements->first($criteria);
    }

    public function addAchievement(Uuid $id, Uuid $taskId, ProgramAggregate $program)
    {
        if ($this->status !== CardStatus::ACTIVE) {
            throw Exception::of(Messages::CARD_IS_NOT_ACTIVE);
        }
        if (!$program->active) {
            throw Exception::of(Messages::PROGRAM_IS_NOT_ACTIVE);
        }
        if ($program->reward->getTarget() <= $this->achievements->count()) {
            throw Exception::of(Messages::PROGRAM_TARGET_ALREADY_REACHED);
        };

        $task = $program->findTask(fn(TaskEntity $e) => $e->id->isEquals($taskId));
        if (!$task) {
            throw Exception::of(Messages::NOT_FOUND);
        }
        if (!$task->active) {
            throw Exception::of(Messages::TASK_IS_NOT_ACTIVE);
        }

        $achieved = $this->findAchievement(
            fn(AchievementEntity $e) => $e->id->isEquals($id)
        );
        if (!$task->feature->isRepeatable() && $achieved) {
            throw Exception::of(Messages::CARD_TASK_ALREADY_ACHIEVED);
        }

        $achievement = AchievementEntity::add($id, $taskId);

        $this->achievements = $this->achievements->add($achievement);

        return $achievement->id;
    }

    public function removeAchievement(Uuid $achievementId)
    {
        if ($this->status !== CardStatus::ACTIVE) {
            throw Exception::of(Messages::CARD_IS_NOT_ACTIVE);
        }

        $achievements = $this->achievements->reject(
            fn(AchievementEntity $e) => $e->id->isEquals($achievementId)
        );

        if (!$achievements->count()) {
            throw Exception::of(Messages::NOT_FOUND);
        }

        $this->achievements = $achievements;
    }

    //

    public static function of(
        Uuid       $id,
        Uuid       $companyId,
        Uuid       $programId,
        Uuid       $holderId,
        string     $comment,
        CardStatus $status,
        Collection $achievements
    )
    {
        $self = new self();
        $self->id = $id;
        $self->companyId = $companyId;
        $self->programId = $programId;
        $self->holderId = $holderId;
        $self->comment = $comment;
        $self->status = $status;
        $self->achievements = $achievements;
        return $self;
    }
}
