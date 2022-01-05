<?php

namespace CardzApp\Api\Collect\Application\Services;

use App\Models\Collect\Program;
use App\Models\Collect\ProgramTask;
use CardzApp\Api\Collect\Domain\ProgramProfile;
use CardzApp\Api\Collect\Domain\ProgramTaskProfile;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;

class ProgramTaskService
{
    public function __construct(
        private UuidGenerator $uuidGenerator
    )
    {
    }

    public function addProgramTask(string $programId, ProgramTaskProfile $profile)
    {
        $program = Program::query()->findOrFail($programId);

        $task = ProgramTask::make($profile->toArray());
        $task->id = $this->uuidGenerator->getNextValue();
        $task->available = false;
        $task->repeatable = false;

        $task->company()->associate($program->company->id);
        $task->program()->associate($program->id);

        $task->save();

        return $task->id;
    }

    public function updateProgramTask(string $taskId, ProgramProfile $profile)
    {
        return Program::query()
            ->findOrFail($taskId)
            ->fill($profile->toArray())
            ->save();
    }

    public function updateProgramTaskAvailability(string $taskId, bool $value)
    {
        return Program::query()
            ->whereNotIn('available', [$value])
            ->findOrFail($taskId)
            ->setAttribute('available', $value)
            ->save();
    }

    //

    public function getProgramTasks(string $programId)
    {
        return ProgramTask::query()
            ->ofProgram($programId)
            ->orderBy('updated_at', 'desc')
            ->limit(100)
            ->get();
    }

    public function getProgramTask(string $programId)
    {
        return Program::query()
            ->findOrFail($programId);
    }
}
