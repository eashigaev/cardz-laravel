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
        $task->active = false;
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

    public function updateProgramTaskActive(string $taskId, bool $value)
    {
        return ProgramTask::query()
            ->whereNotIn('active', [$value])
            ->findOrFail($taskId)
            ->setAttribute('active', $value)
            ->save();
    }

    //

    public function getProgramTasks(string $programId)
    {
        return ProgramTask::query()
            ->where('program_id', $programId)
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
