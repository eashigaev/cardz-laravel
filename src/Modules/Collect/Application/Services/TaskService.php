<?php

namespace CardzApp\Modules\Collect\Application\Services;

use App\Models\Collect\Program;
use App\Models\Collect\Task;
use CardzApp\Modules\Collect\Domain\TaskAggregate;
use CardzApp\Modules\Collect\Domain\TaskFeature;
use CardzApp\Modules\Collect\Domain\TaskProfile;
use CardzApp\Modules\Collect\Infrastructure\Repositories\ProgramRepository;
use CardzApp\Modules\Collect\Infrastructure\Repositories\TaskRepository;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;

class TaskService
{
    public function __construct(
        private UuidGenerator     $uuidGenerator,
        private ProgramRepository $programRepository,
        private TaskRepository $taskRepository
    )
    {
    }

    public function addProgramTask(string $programId, TaskProfile $profile, TaskFeature $feature)
    {
        $program = Program::query()->findOrFail($programId);

        $aggregate = TaskAggregate::add(
            Uuid::of($this->uuidGenerator->getNextValue()),
            $this->programRepository->of($program),
            $profile,
            $feature
        );
        $this->taskRepository->save($aggregate);

        return $aggregate->id->getValue();
    }

    public function updateProgramTask(string $taskId, TaskProfile $profile, TaskFeature $feature)
    {
        $task = Task::query()->findOrFail($taskId);

        $aggregate = $this->taskRepository->of($task);
        $aggregate->update($profile, $feature);
        $this->taskRepository->save($aggregate);
    }

    public function updateProgramTaskActive(string $taskId, bool $value)
    {
        $task = Task::query()->findOrFail($taskId);

        $aggregate = $this->taskRepository->of($task);
        $aggregate->updateActive($value);
        $this->taskRepository->save($aggregate);
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
