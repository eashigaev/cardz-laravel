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
use Codderz\YokoLite\Infrastructure\Database\PersistenceTrait;
use Codderz\YokoLite\Infrastructure\Registry\Registry;

class EloquentProgramRepository implements ProgramRepository
{
    use PersistenceTrait;

    public function __construct(private Registry $registry)
    {
    }

    public function ofIdOrFail(Uuid $programId)
    {
        $model = Program::query()->with('tasks')->findOrFail($programId->getValue());

        return $this->of($model);
    }

    public function ofTaskIdOrFail(Uuid $taskId)
    {
        $model = Task::query()->with('program', 'program.tasks')->findOrFail($taskId->getValue());

        return $this->of($model->program);
    }

    public function of(Program $program): ProgramAggregate
    {
        $this->registry->set($program->id, $program);

        $tasks = $program->tasks->map(fn(Task $item) => TaskEntity::of(
            Uuid::of($item->id),
            TaskProfile::of($item->title, $item->description),
            TaskFeature::of($item->repeatable),
            $item->active
        ));

        return ProgramAggregate::of(
            Uuid::of($program->id),
            Uuid::of($program->company_id),
            ProgramProfile::of($program->title, $program->description),
            ProgramReward::of($program->reward_title, $program->reward_target),
            $program->active,
            $tasks
        );
    }

    //

    public function save(ProgramAggregate $aggregate)
    {
        $program = $this->registry->get($aggregate->id->getValue(), Program::make());

        $this->execute(function () use ($aggregate, $program) {
            $this->saveProgram($aggregate, $program);
            $this->syncTasks($aggregate, $program);
        });
    }

    private function saveProgram(ProgramAggregate $aggregate, Program $program)
    {
        $program->forceFill([
            'id' => $aggregate->id->getValue(),
            'company_id' => $aggregate->companyId->getValue(),
            'title' => $aggregate->profile->getTitle(),
            'description' => $aggregate->profile->getDescription(),
            'reward_title' => $aggregate->reward->getTitle(),
            'reward_target' => $aggregate->reward->getTarget(),
            'active' => $aggregate->active,
        ]);
        $program->save();
    }

    private function syncTasks(ProgramAggregate $aggregate, Program $program)
    {
        $items = $aggregate->tasks->map(fn(TaskEntity $item) => [
            'id' => $item->id->getValue(),
            'company_id' => $aggregate->companyId->getValue(),
            'program_id' => $aggregate->id->getValue(),
            'title' => $item->profile->getTitle(),
            'description' => $item->profile->getDescription(),
            'repeatable' => $item->feature->isRepeatable(),
            'active' => $item->active
        ]);
        $program->tasks()->sync($items->toArray());
    }
}
