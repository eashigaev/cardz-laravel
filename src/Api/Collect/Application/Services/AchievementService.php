<?php

namespace CardzApp\Api\Collect\Application\Services;

use App\Models\Collect\Achievement;
use App\Models\Collect\Card;
use App\Models\Collect\Task;
use CardzApp\Api\Collect\Domain\CardStatus;
use CardzApp\Api\Collect\Domain\Messages;
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

        $task = Task::query()
            ->where(['active' => true, 'program_id' => $card->program_id])
            ->findOrFail($taskId);

        if ($card->status !== CardStatus::ACTIVE->value) {
            throw Exception::of(Messages::CARD_IS_NOT_ACTIVE);
        }

        if (!$card->program->active) {
            throw Exception::of(Messages::PROGRAM_IS_NOT_ACTIVE);
        }

        if (!$task->active) {
            throw Exception::of(Messages::TASK_IS_NOT_ACTIVE);
        }

        $timesCount = $card->tasks()->where(['task_id' => $taskId])->count();
        if (!$task->repeatable && $timesCount) {
            throw Exception::of(Messages::ACHIEVEMENT_ALREADY_EXISTS);
        }

        $achievement = Achievement::make();

        $achievement->id = $this->uuidGenerator->getNextValue();
        $achievement->company()->associate($card->company_id);
        $achievement->program()->associate($card->program_id);
        $achievement->task()->associate($task->id);
        $achievement->card()->associate($card->id);

        $achievement->save();

        return $achievement->id;
    }

    public function removeAchievement(string $cardId, string $taskId)
    {
        $card = Card::query()->findOrFail($cardId);

        if ($card->status !== CardStatus::ACTIVE->value) {
            throw Exception::of(Messages::CARD_IS_NOT_ACTIVE);
        }

        return $card->tasks()->findOrFail($taskId)->delete();
    }
}
