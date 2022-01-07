<?php

namespace CardzApp\Api\Collect\Application\Services;

use App\Models\Collect\Program;
use App\Models\Collect\ProgramTask;
use CardzApp\Api\Collect\Domain\ProgramTaskFeature;
use CardzApp\Api\Collect\Domain\ProgramTaskProfile;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;

class ProgramTaskService
{
    public function __construct(
        private UuidGenerator $uuidGenerator
    )
    {
    }

    public function addProgramTask(string $programId, ProgramTaskProfile $profile, ProgramTaskFeature $feature)
    {
        $program = Program::query()->findOrFail($programId);

        $task = ProgramTask::make();
        $task->id = $this->uuidGenerator->getNextValue();
        $task->available = false;
        $task->setProfile($profile);
        $task->setFeature($feature);
        $task->company()->associate($program->company_id);
        $task->program()->associate($program->id);

        $task->save();

        return $task->id;
    }

    public function updateProgramTask(string $taskId, ProgramTaskProfile $profile, ProgramTaskFeature $feature)
    {
        $task = ProgramTask::query()->findOrFail($taskId);
        $task->setProfile($profile);
        $task->setFeature($feature);

        return $task->save();
    }

    public function updateProgramTaskAvailable(string $taskId, bool $value)
    {
        return ProgramTask::query()
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

    public function getProgramTask(string $taskId)
    {
        return ProgramTask::query()
            ->findOrFail($taskId);
    }
}
