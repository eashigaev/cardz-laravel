<?php

namespace CardzApp\Modules\Collect\Infrastructure\Repositories;

use App\Models\Collect\Program;
use App\Models\Collect\Task;
use CardzApp\Modules\Collect\Domain\ProgramAggregate;
use CardzApp\Modules\Collect\Domain\ProgramProfile;
use CardzApp\Modules\Collect\Domain\ProgramReward;
use CardzApp\Modules\Collect\Domain\TaskEntity;
use CardzApp\Modules\Collect\Domain\TaskFeature;
use CardzApp\Modules\Collect\Domain\TaskProfile;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Codderz\YokoLite\Infrastructure\PersistenceTrait;
use Illuminate\Support\Collection;

class ProgramRepository
{
    use PersistenceTrait;

    public function ofIdOrFail(Uuid $programId)
    {
        $model = Program::query()
            ->with('tasks')
            ->findOrFail($programId->getValue());

        return $this->of($model);
    }

    public function ofTaskIdOrFail(Uuid $taskId)
    {
        $model = Task::query()->with('program', 'program.tasks')
            ->findOrFail($taskId->getValue());

        return $this->of($model->program);
    }

    public function of(Program $program): ProgramAggregate
    {
        $tasks = $program->tasks->map(fn(Task $task) => TaskEntity::of(
            Uuid::of($task->id),
            TaskProfile::of($task->title, $task->description),
            TaskFeature::of($task->repeatable),
            $task->active
        ));

        return ProgramAggregate::of(
            Uuid::of($program->id),
            Uuid::of($program->company_id),
            ProgramProfile::of($program->title, $program->description),
            ProgramReward::of($program->reward_title, $program->reward_target),
            $program->active,
            $tasks
        )
            ->withMetaVersion($program->meta_version);
    }

    //

    public function create(ProgramAggregate $aggregate)
    {
        $this->execute(function () use ($aggregate) {
            Program::query()->insert([
                'id' => $aggregate->id->getValue(),
                'company_id' => $aggregate->companyId->getValue(),
                'title' => $aggregate->profile->getTitle(),
                'description' => $aggregate->profile->getDescription(),
                'reward_title' => $aggregate->reward->getTitle(),
                'reward_target' => $aggregate->reward->getTarget(),
                'active' => $aggregate->active,
                'meta_version' => $aggregate->nextMetaVersion()
            ]);
            $this->saveTasks($aggregate);
        });
    }

    public function update(ProgramAggregate $aggregate)
    {
        $this->execute(function () use ($aggregate) {
            Program::query()->where([
                'id' => $aggregate->id->getValue(),
                'meta_version' => $aggregate->getMetaVersion()
            ])->update([
                'title' => $aggregate->profile->getTitle(),
                'description' => $aggregate->profile->getDescription(),
                'reward_title' => $aggregate->reward->getTitle(),
                'reward_target' => $aggregate->reward->getTarget(),
                'active' => $aggregate->active,
                'meta_version' => $aggregate->nextMetaVersion()
            ]);
            $this->saveTasks($aggregate);
        });
    }

    private function saveTasks(ProgramAggregate $aggregate)
    {
        /** @var Collection<TaskEntity> $task */
        foreach ($aggregate->tasks as $task) {
            Task::query()->updateOrCreate([
                'id' => $task->id->getValue(),
            ], [
                'company_id' => $aggregate->companyId->getValue(),
                'program_id' => $aggregate->id->getValue(),
                'title' => $task->profile->getTitle(),
                'description' => $task->profile->getDescription(),
                'repeatable' => $task->feature->isRepeatable(),
                'active' => $task->active
            ]);
        }
    }
}
