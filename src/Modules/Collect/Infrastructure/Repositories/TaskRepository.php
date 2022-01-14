<?php

namespace CardzApp\Modules\Collect\Infrastructure\Repositories;

use App\Models\Collect\Task;
use CardzApp\Modules\Collect\Domain\TaskAggregate;
use CardzApp\Modules\Collect\Domain\TaskFeature;
use CardzApp\Modules\Collect\Domain\TaskProfile;
use Codderz\YokoLite\Domain\Uuid\Uuid;

class TaskRepository
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
        )
            ->withMetaVersion($task->meta_version);
    }

    public function create(TaskAggregate $aggregate)
    {
        Task::query()->insert([
            'id' => $aggregate->id->getValue(),
            'company_id' => $aggregate->companyId->getValue(),
            'program_id' => $aggregate->programId->getValue(),
            'title' => $aggregate->profile->getTitle(),
            'description' => $aggregate->profile->getDescription(),
            'repeatable' => $aggregate->feature->isRepeatable(),
            'active' => $aggregate->active,
            'meta_version' => $aggregate->nextMetaVersion()
        ]);
    }

    public function update(TaskAggregate $aggregate)
    {
        Task::query()->where([
            'id' => $aggregate->id->getValue(),
            'meta_version' => $aggregate->getMetaVersion()
        ])->update([
            'title' => $aggregate->profile->getTitle(),
            'description' => $aggregate->profile->getDescription(),
            'repeatable' => $aggregate->feature->isRepeatable(),
            'active' => $aggregate->active,
            'meta_version' => $aggregate->nextMetaVersion()
        ]);
    }
}
