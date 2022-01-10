<?php

namespace CardzApp\Api\Collect\Application\Services;

use App\Models\Collect\Card;
use App\Models\Collect\Achievement;
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

    public function completeCardTask(string $cardId, string $taskId)
    {
        $card = Card::query()->with(['program', 'tasks'])->findOrFail($cardId);

        $programTask = Task::query()
            ->where(['active' => true, 'program_id' => $card->program_id])
            ->findOrFail($taskId);

        if (CardStatus::tryFrom($card->status) !== CardStatus::ACTIVE) {
            throw Exception::of(Messages::CARD_MUST_BE_ACTIVE);
        }

        if (!$card->program->active) {
            throw Exception::of(Messages::PROGRAM_MUST_BE_ACTIVE);
        }

        if (!$programTask->active) {
            throw Exception::of(Messages::PROGRAM_TASK_MUST_BE_ACTIVE);
        }

        $cardTaskCount = $card->tasks()->where(['task_id' => $taskId])->count();
        if (!$programTask->repeatable && $cardTaskCount) {
            throw Exception::of(Messages::CARD_TASK_ALREADY_COMPLETED);
        }

        $cardTask = Achievement::make();

        $cardTask->id = $this->uuidGenerator->getNextValue();
        $cardTask->company()->associate($card->company_id);
        $cardTask->program()->associate($card->program_id);
        $cardTask->task()->associate($programTask->id);
        $cardTask->card()->associate($card->id);

        $cardTask->save();

        return $cardTask->id;
    }

    public function removeCardTask(string $cardId, string $taskId)
    {
        $card = Card::query()->findOrFail($cardId);

        if (CardStatus::tryFrom($card->status) !== CardStatus::ACTIVE) {
            throw Exception::of(Messages::CARD_MUST_BE_ACTIVE);
        }

        return $card->tasks()->findOrFail($taskId)->deleteOrFail();
    }
}
