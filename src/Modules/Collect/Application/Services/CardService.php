<?php

namespace CardzApp\Modules\Collect\Application\Services;

use App\Models\Collect\Card;
use App\Models\Collect\Program;
use App\Models\User;
use CardzApp\Modules\Collect\Domain\CardAggregate;
use CardzApp\Modules\Collect\Infrastructure\Repositories\CardRepository;
use CardzApp\Modules\Collect\Infrastructure\Repositories\ProgramRepository;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;

class CardService
{
    public function __construct(
        private UuidGenerator     $uuidGenerator,
        private ProgramRepository $programRepository,
        private CardRepository    $cardRepository
    )
    {
    }

    public function issueCard(Uuid $programId, Uuid $holderId, string $comment)
    {
        $program = Program::query()->findOrFail($programId->getValue());
        $holder = User::query()->findOrFail($holderId->getValue());

        $aggregate = CardAggregate::issue(
            Uuid::of($this->uuidGenerator->getNextValue()),
            $this->programRepository->of($program),
            $holderId,
            $comment
        );

        $this->cardRepository->create($aggregate);

        return $aggregate->id->getValue();
    }

    public function updateCard(Uuid $cardId, string $comment)
    {
        $card = Card::query()->findOrFail($cardId->getValue());

        $aggregate = $this->cardRepository->of($card);
        $aggregate->update($comment);
        $this->cardRepository->update($aggregate);
    }

    public function rewardCard(Uuid $cardId)
    {
        $card = Card::query()->with('program')->findOrFail($cardId->getValue());

        $programAggregate = $this->programRepository->of($card->program);

        $aggregate = $this->cardRepository->of($card);
        $aggregate->reward($programAggregate);
        $this->cardRepository->update($aggregate);
    }

    public function rejectCard(Uuid $cardId)
    {
        $card = Card::query()->findOrFail($cardId);

        $aggregate = $this->cardRepository->of($card);
        $aggregate->reject();
        $this->cardRepository->update($aggregate);
    }

    public function cancelCard(Uuid $cardId)
    {
        $card = Card::query()->findOrFail($cardId->getValue());

        $aggregate = $this->cardRepository->of($card);
        $aggregate->cancel();
        $this->cardRepository->update($aggregate);
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
