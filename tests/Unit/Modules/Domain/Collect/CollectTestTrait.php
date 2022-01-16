<?php

namespace Tests\Unit\Modules\Domain\Collect;

use CardzApp\Modules\Collect\Domain\AchievementEntity;
use CardzApp\Modules\Collect\Domain\CardAggregate;
use CardzApp\Modules\Collect\Domain\CardStatus;
use CardzApp\Modules\Collect\Domain\ProgramAggregate;
use CardzApp\Modules\Collect\Domain\ProgramProfile;
use CardzApp\Modules\Collect\Domain\ProgramReward;
use CardzApp\Modules\Collect\Domain\TaskEntity;
use CardzApp\Modules\Collect\Domain\TaskFeature;
use CardzApp\Modules\Collect\Domain\TaskProfile;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Codderz\YokoLite\Domain\Uuid\UuidTestTrait;
use Illuminate\Support\Collection;

trait CollectTestTrait
{
    use UuidTestTrait;

    private function makeProgram(int $rewardTarget = 3, bool $active = true)
    {
        return ProgramAggregate::of(
            Uuid::of($this->uuidGenerator()->getNextValue()),
            Uuid::of($this->uuidGenerator()->getNextValue()),
            ProgramProfile::of('Program title', 'Program description'),
            ProgramReward::of('Program reward title', $rewardTarget),
            $active,
            Collection::make([$this->makeTask()])
        );
    }

    private function makeTask(bool $repeatable = true, bool $active = true)
    {
        return TaskEntity::of(
            Uuid::of($this->uuidGenerator()->getNextValue()),
            TaskProfile::of('Task title', 'Task description'),
            TaskFeature::of($repeatable),
            $active
        );
    }

    //

    private function makeCard(
        ProgramAggregate $program,
        CardStatus       $status = CardStatus::ACTIVE,
        Collection       $achievements = null
    )
    {
        return CardAggregate::of(
            Uuid::of($this->uuidGenerator()->getNextValue()),
            $program->companyId,
            $program->id,
            Uuid::of($this->uuidGenerator()->getNextValue()),
            'Sample comment',
            $status,
            $achievements ?? Collection::times($program->reward->getTarget())
                ->map(fn() => $this->makeAchievement())
        );
    }

    private function makeAchievement(Uuid $taskId = null)
    {
        return AchievementEntity::of(
            Uuid::of($this->uuidGenerator()->getNextValue()),
            $taskId ?? Uuid::of($this->uuidGenerator()->getNextValue()),
        );
    }
}
