<?php

namespace CardzApp\Modules\Collect\Application\Services;

use App\Models\Collect\Card;
use App\Models\Collect\Program;
use App\Models\User;
use CardzApp\Modules\Collect\Application\Repositories\CardRepository;
use CardzApp\Modules\Collect\Application\Repositories\ProgramRepository;
use CardzApp\Modules\Collect\Domain\CardAggregate;
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
            Uuid::of($holder->id),
            $comment
        );

        $this->cardRepository->save($aggregate);

        return $aggregate->id->getValue();
    }

    public function updateCard(Uuid $cardId, string $comment)
    {
        $aggregate = $this->cardRepository->ofIdOrFail($cardId);

        $aggregate->update($comment);

        $this->cardRepository->save($aggregate);
    }

    public function rewardCard(Uuid $cardId)
    {
        $aggregate = $this->cardRepository->ofIdOrFail($cardId);
        $programAggregate = $this->programRepository->ofIdOrFail($aggregate->programId);

        $aggregate->reward($programAggregate);

        $this->cardRepository->save($aggregate);
    }

    public function rejectCard(Uuid $cardId)
    {
        $aggregate = $this->cardRepository->ofIdOrFail($cardId);

        $aggregate->reject();

        $this->cardRepository->save($aggregate);
    }

    public function cancelCard(Uuid $cardId)
    {
        $aggregate = $this->cardRepository->ofIdOrFail($cardId);

        $aggregate->cancel();

        $this->cardRepository->save($aggregate);
    }

    //

    public function getCards(string $programId, int $page)
    {
        return Card::query()
            ->with('program')
            ->where('program_id', $programId)
            ->limit(100)
            ->orderBy('updated_at')
            ->paginate(perPage: 10, page: $page);
    }

    public function getCard(string $cardId)
    {
        return Card::query()
            ->with('program', 'holder')
            ->findOrFail($cardId);
    }
}
