<?php

namespace CardzApp\Modules\Collect\Infrastructure\Repositories;

use App\Models\Collect\Achievement;
use CardzApp\Modules\Collect\Domain\AchievementAggregate;
use Codderz\YokoLite\Domain\Uuid\Uuid;

class AchievementRepository
{
    public function of(Achievement $achievement): AchievementAggregate
    {
        return AchievementAggregate::of(
            Uuid::of($achievement->id),
            Uuid::of($achievement->company_id),
            Uuid::of($achievement->program_id),
            Uuid::of($achievement->task_id),
            Uuid::of($achievement->card_id)
        );
    }

    public function create(AchievementAggregate $aggregate)
    {
        Achievement::query()->insert([
            'id' => $aggregate->id->getValue(),
            'company_id' => $aggregate->companyId->getValue(),
            'program_id' => $aggregate->programId->getValue(),
            'task_id' => $aggregate->taskId->getValue(),
            'card_id' => $aggregate->cardId->getValue()
        ]);
    }

    public function delete(AchievementAggregate $aggregate)
    {
        Achievement::query()->where([
            'id' => $aggregate->id->getValue(),
        ])->delete();
    }
}
