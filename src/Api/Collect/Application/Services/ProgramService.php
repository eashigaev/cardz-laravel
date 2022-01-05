<?php

namespace CardzApp\Api\Collect\Application\Services;

use App\Models\Collect\Program;
use App\Models\Collect\ProgramBuilder;
use App\Models\Company;
use CardzApp\Api\Collect\Domain\ProgramProfile;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;

class ProgramService
{
    public function __construct(
        private UuidGenerator $uuidGenerator
    )
    {
    }

    public function addProgram(string $companyId, ProgramProfile $profile)
    {
        $company = Company::query()->findOrFail($companyId);

        $program = Program::make($profile->toArray());
        $program->id = $this->uuidGenerator->getNextValue();
        $program->available = false;
        $program->company()->associate($company);

        $program->save();

        return $program->id;
    }

    public function updateProgram(string $programId, ProgramProfile $profile)
    {
        return Program::query()
            ->findOrFail($programId)
            ->fill($profile->toArray())
            ->save();
    }

    public function updateProgramAvailability(string $programId, bool $value)
    {
        return Program::query()
            ->whereNotIn('available', [$value])
            ->findOrFail($programId)
            ->setAttribute('available', $value)
            ->save();
    }

    //

    public function getPrograms(string $companyId, array $filter = [])
    {
        return Program::query()
            ->ofCompany($companyId)
            ->when(in_array('available', $filter),
                fn(ProgramBuilder $builder, bool $value) => $builder->where('available', $value)
            )
            ->limit(1000)
            ->get();
    }

    public function getProgram(string $programId)
    {
        return Program::query()
            ->findOrFail($programId);
    }
}
