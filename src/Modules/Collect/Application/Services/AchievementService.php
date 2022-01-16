<?php

namespace CardzApp\Modules\Collect\Application\Services;

use CardzApp\Modules\Collect\Infrastructure\Repositories\CardRepository;
use CardzApp\Modules\Collect\Infrastructure\Repositories\ProgramRepository;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;

class AchievementService
{
    public function __construct(
        private UuidGenerator     $uuidGenerator,
        private CardRepository    $cardRepository,
        private ProgramRepository $programRepository
    )
    {
    }

    public function addAchievement(Uuid $cardId, Uuid $taskId)
    {
        $aggregate = $this->cardRepository->ofIdOrFail($cardId);
        $programAggregate = $this->programRepository->ofIdOrFail($aggregate->programId);

        $achievementId = $aggregate->addAchievement(
            Uuid::of($this->uuidGenerator->getNextValue()),
            $taskId,
            $programAggregate
        );

        $this->cardRepository->save($aggregate);

        return $achievementId->getValue();
    }

    public function removeAchievement(Uuid $id)
    {
        $aggregate = $this->cardRepository->ofAchievementIdOrFail($id);

        $aggregate->removeAchievement($id);

        $this->cardRepository->save($aggregate);
    }
}
