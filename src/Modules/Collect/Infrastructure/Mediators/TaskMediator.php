<?php

namespace CardzApp\Modules\Collect\Infrastructure\Mediators;

use App\Models\Collect\Task;
use CardzApp\Modules\Collect\Domain\TaskAggregate;
use CardzApp\Modules\Collect\Domain\TaskFeature;
use CardzApp\Modules\Collect\Domain\TaskProfile;
use Codderz\YokoLite\Domain\Uuid\Uuid;

class TaskMediator
{
    public function of(Task $task): TaskAggregate
    {
        return TaskAggregate::of(
            Uuid::of($task->id),
            Uuid::of($task->company_id),
            Uuid::of($task->program_id),
            TaskProfile::of($task->title, $task->description),
            TaskFeature::of($task->repeatable),
            $task->active
        );
    }

    public function save(TaskAggregate $aggregate)
    {
        $task = Task::firstOrNew();
        $task->id = $aggregate->id->getValue();
        $task->company_id = $aggregate->companyId->getValue();
        $task->program_id = $aggregate->programId->getValue();
        $task->title = $aggregate->profile->getTitle();
        $task->description = $aggregate->profile->getDescription();
        $task->repeatable = $aggregate->feature->isRepeatable();
        $task->active = $aggregate->active;
        $task->save();
    }
}
