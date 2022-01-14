<?php

namespace CardzApp\Modules\Collect\Application\Services;

use App\Models\Collect\Achievement;
use App\Models\Collect\Card;
use CardzApp\Modules\Collect\Application\Events\CardAchievementsChanged;
use CardzApp\Modules\Collect\Domain\AchievementAggregate;
use CardzApp\Modules\Collect\Infrastructure\Repositories\AchievementRepository;
use CardzApp\Modules\Collect\Infrastructure\Repositories\CardRepository;
use CardzApp\Modules\Collect\Infrastructure\Repositories\ProgramRepository;
use CardzApp\Modules\Collect\Infrastructure\Repositories\TaskRepository;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;

class AchievementService
{
    public function __construct(
        private UuidGenerator         $uuidGenerator,
        private ProgramRepository     $programRepository,
        private TaskRepository        $taskRepository,
        private CardRepository        $cardRepository,
        private AchievementRepository $achievementRepository
    )
    {
    }

    public function addAchievement(string $cardId, string $taskId)
    {
        $card = Card::query()->with(['program', 'achievements'])->findOrFail($cardId);
        $task = $card->program->tasks->firstOrFail('id', $taskId);

        $aggregate = AchievementAggregate::add(
            Uuid::of($this->uuidGenerator->getNextValue()),
            $this->programRepository->of($card->program),
            $this->taskRepository->of($task),
            $this->cardRepository->of($card),
            $card->achievements->pluck('task_id')
        );
        $this->achievementRepository->create($aggregate);

        CardAchievementsChanged::dispatch($card->refresh());

        return $aggregate->id->getValue();
    }

    public function removeAchievement(string $achievementId)
    {
        $achievement = Achievement::query()->with(['card'])->findOrFail($achievementId);

        $cardAggregate = $this->cardRepository->of($achievement->card);

        $aggregate = $this->achievementRepository->of($achievement);
        $aggregate->remove($cardAggregate);
        $this->achievementRepository->delete($aggregate);

        CardAchievementsChanged::dispatch($achievement->card->refresh());

        return $achievement->id;
    }
}
