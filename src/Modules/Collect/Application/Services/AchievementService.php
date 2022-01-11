<?php

namespace CardzApp\Modules\Collect\Application\Services;

use App\Models\Collect\Achievement;
use App\Models\Collect\Card;
use App\Models\Collect\Task;
use CardzApp\Modules\Collect\Application\Events\CardAchievementsChanged;
use CardzApp\Modules\Collect\Domain\CardStatus;
use CardzApp\Modules\Collect\Domain\Messages;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Codderz\YokoLite\Shared\Exception;

class AchievementService
{
    public function __construct(
        private UuidGenerator $uuidGenerator,
    )
    {
    }

    public function addAchievement(string $cardId, string $taskId)
    {
        $card = Card::query()->with(['program', 'achievements'])->findOrFail($cardId);

        $task = Task::query()->where(['program_id' => $card->program_id])->findOrFail($taskId);

        if (CardStatus::ACTIVE->is($card->status)) {
            throw Exception::of(Messages::CARD_IS_NOT_ACTIVE);
        }

        if (!$card->program->active) {
            throw Exception::of(Messages::PROGRAM_IS_NOT_ACTIVE);
        }

        if (!$task->active) {
            throw Exception::of(Messages::TASK_IS_NOT_ACTIVE);
        }

        if (!$task->repeatable && $card->achievements->find($taskId, 'task_id')) {
            throw Exception::of(Messages::ACHIEVEMENT_ALREADY_EXISTS);
        }

        if ($card->program->reward_target <= $card->achievements->count()) {
            throw Exception::of(Messages::PROGRAM_TARGET_REACHED);
        }

        $achievement = Achievement::make();

        $achievement->id = $this->uuidGenerator->getNextValue();
        $achievement->company()->associate($card->company_id);
        $achievement->program()->associate($card->program_id);
        $achievement->task()->associate($task->id);
        $achievement->card()->associate($card->id);

        $achievement->save();

        CardAchievementsChanged::dispatch($card);

        return $achievement->id;
    }

    public function removeAchievement(string $achievementId)
    {
        $achievement = Achievement::query()->with(['card', 'program'])->findOrFail($achievementId);

        if (!CardStatus::ACTIVE->is($achievement->card->status)) {
            throw Exception::of(Messages::CARD_IS_NOT_ACTIVE);
        }

        if (!$achievement->program->active) {
            throw Exception::of(Messages::PROGRAM_IS_NOT_ACTIVE);
        }

        $achievement->delete();

        CardAchievementsChanged::dispatch($achievement->card);

        return $achievement->id;
    }
}
