<?php

namespace CardzApp\Modules\Collect\Application\Services;

use App\Models\Collect\Program;
use App\Models\Collect\Task;
use CardzApp\Modules\Collect\Domain\TaskFeature;
use CardzApp\Modules\Collect\Domain\TaskProfile;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;

class TaskService
{
    public function __construct(
        private UuidGenerator $uuidGenerator
    )
    {
    }

    public function addProgramTask(string $programId, TaskProfile $profile, TaskFeature $feature)
    {
        $program = Program::query()->findOrFail($programId);

        $task = Task::make();
        $task->id = $this->uuidGenerator->getNextValue();
        $task->active = false;
        $task->setProfile($profile);
        $task->setFeature($feature);
        $task->company()->associate($program->company_id);
        $task->program()->associate($program->id);

        $task->save();

        return $task->id;
    }

    public function updateProgramTask(string $taskId, TaskProfile $profile, TaskFeature $feature)
    {
        $task = Task::query()->findOrFail($taskId);
        $task->setProfile($profile);
        $task->setFeature($feature);

        return $task->save();
    }

    public function updateProgramTaskActive(string $taskId, bool $value)
    {
        $task = Task::query()
            ->whereNotIn('active', [$value])
            ->findOrFail($taskId);

        $task->active = $value;

        return $task->save();
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
