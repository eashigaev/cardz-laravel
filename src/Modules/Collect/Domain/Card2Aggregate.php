<?php

namespace CardzApp\Modules\Collect\Domain;

use Codderz\YokoLite\Domain\OptimisticLockingTrait;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Codderz\YokoLite\Shared\Exception;
use Illuminate\Support\Collection;

class Card2Aggregate
{
    use OptimisticLockingTrait;

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

        $balance = 0;
        $status = CardStatus::ACTIVE;

        return self::of(
            $id, $program->companyId, $program->id, $holderId, $comment, $balance, $status
        );
    }

    public function update(string $comment)
    {
        $this->comment = $comment;
    }

    public function updateBalance(Collection $achievedTaskIds)
    {
        $this->balance = $achievedTaskIds->count();
    }

    public function reward(ProgramAggregate $program)
    {
        if (CardStatus::ACTIVE !== $this->status) {
            throw Exception::of(Messages::CARD_IS_NOT_ACTIVE);
        }
        if (!$program->active) {
            throw Exception::of(Messages::PROGRAM_IS_NOT_ACTIVE);
        }
        if ($this->balance < $program->reward->getTarget()) {
            throw Exception::of(Messages::CARD_BALANCE_IS_NOT_ENOUGH);
        }

        $this->balance -= $program->reward->getTarget();
        $this->status = CardStatus::REWARDED;
    }

    public function reject()
    {
        if (CardStatus::ACTIVE !== $this->status) {
            throw Exception::of(Messages::CARD_IS_NOT_ACTIVE);
        }

        $this->status = CardStatus::REJECTED;
    }

    public function cancel()
    {
        if (CardStatus::ACTIVE !== $this->status) {
            throw Exception::of(Messages::CARD_IS_NOT_ACTIVE);
        }

        $this->status = CardStatus::CANCELLED;
    }

    //

    public static function of(
        Uuid       $id,
        Uuid       $companyId,
        Uuid       $programId,
        Uuid       $holderId,
        string     $comment,
        int        $balance,
        CardStatus $status
    )
    {
        $self = new self();
        $self->id = $id;
        $self->companyId = $companyId;
        $self->programId = $programId;
        $self->holderId = $holderId;
        $self->comment = $comment;
        $self->balance = $balance;
        $self->status = $status;
        return $self;
    }
}
