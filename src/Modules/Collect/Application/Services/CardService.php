<?php

namespace CardzApp\Modules\Collect\Application\Services;

use App\Models\Collect\Card;
use App\Models\Collect\Program;
use CardzApp\Modules\Account\Application\Services\UserService;
use CardzApp\Modules\Collect\Domain\CardStatus;
use CardzApp\Modules\Collect\Domain\Messages;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Codderz\YokoLite\Shared\Exception;

class CardService
{
    public function __construct(
        private UuidGenerator $uuidGenerator,
        private UserService   $userService
    )
    {
    }

    public function issueCard(string $programId, string $holderId, string $comment)
    {
        $program = Program::query()->findOrFail($programId);


        $holder = $this->userService->getUser($holderId);

        $card = Card::make();

        $card->id = $this->uuidGenerator->getNextValue();
        $card->status = CardStatus::ACTIVE->value;
        $card->balance = 0;
        $card->comment = $comment;
        $card->program_active = $program->active;
        $card->company()->associate($program->company_id);
        $card->program()->associate($program->id);
        $card->holder()->associate($holder->id);

        $card->save();

        return $card->id;
    }

    public function updateCard(string $cardId, string $comment)
    {
        $card = Card::query()->findOrFail($cardId);

        $card->comment = $comment;

        return $card->save();
    }

    public function rewardCard(string $cardId)
    {
        $card = Card::query()->with('program')->findOrFail($cardId);

        if (!CardStatus::ACTIVE->is($card->status)) {
            throw Exception::of(Messages::CARD_IS_NOT_ACTIVE);
        }

        if (!$card->program->active) {
            throw Exception::of(Messages::PROGRAM_IS_NOT_ACTIVE);
        }

        if ($card->balance < $card->program->reward_target) {
            throw Exception::of(Messages::CARD_BALANCE_IS_NOT_ENOUGH);
        }

        $card->balance -= $card->program->reward_target;
        $card->status = CardStatus::REWARDED->value;

        return $card->save();
    }

    public function rejectCard(string $cardId)
    {
        $card = Card::query()->findOrFail($cardId);

        if (!CardStatus::ACTIVE->is($card->status)) {
            throw Exception::of(Messages::CARD_IS_NOT_ACTIVE);
        }

        $card->status = CardStatus::REJECTED->value;

        return $card->save();
    }

    public function cancelCard(string $cardId)
    {
        $card = Card::query()->findOrFail($cardId);

        if (!CardStatus::ACTIVE->is($card->status)) {
            throw Exception::of(Messages::CARD_IS_NOT_ACTIVE);
        }

        $card->status = CardStatus::CANCELLED->value;

        return $card->save();
    }

    //

    public function batchUpdateCardsProramActive(string $programId, bool $value)
    {
        return Card::query()
            ->where('program_id', $programId)
            ->update(['program_active' => $value]);
    }

    //

    public function getCards(string $programId)
    {
        return Card::query()
            ->with('program')
            ->where('program', $programId)
            ->limit(100)
            ->get();
    }

    public function getCard(string $cardId)
    {
        return Card::query()
            ->findOrFail($cardId);
    }
}
