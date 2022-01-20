<?php

namespace CardzApp\Modules\Collect\Application\Services;

use App\Models\Collect\Task;
use CardzApp\Modules\Collect\Application\Repositories\ProgramRepository;
use CardzApp\Modules\Collect\Domain\TaskFeature;
use CardzApp\Modules\Collect\Domain\TaskProfile;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;

class TaskService
{
    public function __construct(
        private UuidGenerator     $uuidGenerator,
        private ProgramRepository $programRepository,
    )
    {
    }

    public function addTask(Uuid $programId, TaskProfile $profile, TaskFeature $feature)
    {
        $aggregate = $this->programRepository->ofIdOrFail($programId);

        $taskId = $aggregate->addTask(
            Uuid::of($this->uuidGenerator->getNextValue()),
            $profile,
            $feature
        );

        $this->programRepository->save($aggregate);

        return $taskId->getValue();
    }

    public function updateTask(Uuid $taskId, TaskProfile $profile, TaskFeature $feature)
    {
        $aggregate = $this->programRepository->ofTaskIdOrFail($taskId);

        $aggregate->updateTask($taskId, $profile, $feature);

        $this->programRepository->save($aggregate);
    }

    public function updateTaskActive(Uuid $taskId, bool $value)
    {
        $aggregate = $this->programRepository->ofTaskIdOrFail($taskId);

        $aggregate->updateTaskActive($taskId, $value);

        $this->programRepository->save($aggregate);
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
