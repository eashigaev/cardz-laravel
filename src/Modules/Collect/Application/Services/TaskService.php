<?php

namespace CardzApp\Modules\Collect\Application\Services;

use App\Models\Collect\Program;
use App\Models\Collect\Task;
use CardzApp\Modules\Collect\Domain\TaskAggregate;
use CardzApp\Modules\Collect\Domain\TaskFeature;
use CardzApp\Modules\Collect\Domain\TaskProfile;
use CardzApp\Modules\Collect\Infrastructure\Mediators\ProgramMediator;
use CardzApp\Modules\Collect\Infrastructure\Mediators\TaskMediator;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;

class TaskService
{
    public function __construct(
        private UuidGenerator   $uuidGenerator,
        private ProgramMediator $programMediator,
        private TaskMediator    $taskMediator
    )
    {
    }

    public function addProgramTask(string $programId, TaskProfile $profile, TaskFeature $feature)
    {
        $program = Program::query()->findOrFail($programId);

        $aggregate = TaskAggregate::add(
            Uuid::of($this->uuidGenerator->getNextValue()),
            $this->programMediator->of($program),
            $profile,
            $feature
        );
        $this->taskMediator->save($aggregate);

        return $aggregate->id->getValue();
    }

    public function updateProgramTask(string $taskId, TaskProfile $profile, TaskFeature $feature)
    {
        $task = Task::query()->findOrFail($taskId);

        $aggregate = $this->taskMediator->of($task);
        $aggregate->update($profile, $feature);
        $this->taskMediator->save($aggregate);
    }

    public function updateProgramTaskActive(string $taskId, bool $value)
    {
        $task = Task::query()->findOrFail($taskId);

        $aggregate = $this->taskMediator->of($task);
        $aggregate->updateActive($value);
        $this->taskMediator->save($aggregate);
    }

    //

    public function getProgramTasks(string $programId)
    {
        return Task::query()
            ->where('program_id', $programId)
            ->orderBy('updated_at', 'desc')
            ->limit(100)
            ->get();
    }

    public function getProgramTask(string $taskId)
    {
        return Task::query()
            ->findOrFail($taskId);
    }
}
