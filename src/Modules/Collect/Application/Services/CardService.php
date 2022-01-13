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

    public function issueCard(string $programId, string $holderId, string $comment)
    {
        $program = Program::query()->findOrFail($programId);
        $holder = User::query()->findOrFail($holderId);

        $aggregate = CardAggregate::issue(
            Uuid::of($this->uuidGenerator->getNextValue()),
            $this->programRepository->of($program),
            Uuid::of($holder->id),
            $comment
        );

        $this->cardRepository->save($aggregate);

        return $aggregate->id->getValue();
    }

    public function updateCard(string $cardId, string $comment)
    {
        $card = Card::query()->findOrFail($cardId);

        $aggregate = $this->cardRepository->of($card);
        $aggregate->update($comment);
        $this->cardRepository->save($aggregate);
    }

    public function rewardCard(string $cardId)
    {
        $card = Card::query()->with('program')->findOrFail($cardId);

        $programAggregate = $this->programRepository->of($card->program);

        $aggregate = $this->cardRepository->of($card);
        $aggregate->reward($programAggregate);
        $this->cardRepository->save($aggregate);
    }

    public function rejectCard(string $cardId)
    {
        $card = Card::query()->findOrFail($cardId);

        $aggregate = $this->cardRepository->of($card);
        $aggregate->reject();
        $this->cardRepository->save($aggregate);
    }

    public function cancelCard(string $cardId)
    {
        $card = Card::query()->findOrFail($cardId);

        $aggregate = $this->cardRepository->of($card);
        $aggregate->cancel();
        $this->cardRepository->save($aggregate);
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
