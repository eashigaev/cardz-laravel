<?php

namespace CardzApp\Api\Collect\Application\Services;

use App\Models\Collect\Program;
use App\Models\Company;
use CardzApp\Api\Collect\Application\Events\ProgramActiveUpdated;
use CardzApp\Api\Collect\Domain\ProgramProfile;
use CardzApp\Api\Collect\Domain\ProgramReward;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Illuminate\Database\Eloquent\Builder;

class ProgramService
{
    public function __construct(
        private UuidGenerator $uuidGenerator
    )
    {
    }

    public function addProgram(string $companyId, ProgramProfile $profile, ProgramReward $reward)
    {
        $company = Company::query()->findOrFail($companyId);

        $program = Program::make();

        $program->id = $this->uuidGenerator->getNextValue();
        $program->active = false;
        $program->setProfile($profile);
        $program->setReward($reward);
        $program->company()->associate($company->id);

        $program->save();

        return $program->id;
    }

    public function updateProgram(string $programId, ProgramProfile $profile, ProgramReward $reward)
    {
        $program = Program::query()->findOrFail($programId);

        $program->setProfile($profile);
        $program->setReward($reward);

        return $program->save();
    }

    public function updateProgramActive(string $programId, bool $value)
    {
        $program = Program::query()
            ->whereNotIn('active', [$value])
            ->findOrFail($programId);

        $program->active = $value;
        $program->save();

        ProgramActiveUpdated::dispatch($program);

        return true;
    }

    //

    public function getPrograms(string $companyId, array $filter = [])
    {
        return Program::query()
            ->where('company_id', $companyId)
            ->when(in_array('active', $filter),
                fn(Builder $builder, bool $value) => $builder->where('active', $value)
            )
            ->limit(100)
            ->get();
    }

    public function getProgram(string $programId)
    {
        return Program::query()
            ->findOrFail($programId);
    }
}
