<?php

namespace CardzApp\Modules\Collect\Application\Services;

use App\Models\Collect\Program;
use App\Models\Company;
use CardzApp\Modules\Collect\Application\Events\ProgramActiveUpdated;
use CardzApp\Modules\Collect\Application\Mapper;
use CardzApp\Modules\Collect\Domain\ProgramAggregate;
use CardzApp\Modules\Collect\Domain\ProgramProfile;
use CardzApp\Modules\Collect\Domain\ProgramReward;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Illuminate\Database\Eloquent\Builder;

class ProgramService
{
    public function __construct(
        private UuidGenerator $uuidGenerator,
        private Mapper        $mapper
    )
    {
    }

    public function addProgram(string $companyId, ProgramProfile $profile, ProgramReward $reward)
    {
        $companyAggregate = $this->mapper->companyAggregate(
            Company::query()->findOrFail($companyId)
        );

        $programAggregate = ProgramAggregate::add(
            Uuid::of($this->uuidGenerator->getNextValue()),
            $companyAggregate,
            $profile,
            $reward
        );

        Program::make()
            ->applyAggregate($programAggregate)
            ->save();

        return $programAggregate->id->getValue();
    }

    public function updateProgram(string $programId, ProgramProfile $profile, ProgramReward $reward)
    {
        $program = Program::query()->findOrFail($programId);
        $programAggregate = $program->toAggregate();

        $programAggregate->update($profile, $reward);

        return $program
            ->applyAggregate($programAggregate)
            ->save();
    }

    public function updateProgramActive(string $programId, bool $value)
    {
        $program = Program::query()->findOrFail($programId);
        $programAggregate = $program->toAggregate();

        $programAggregate->updateActive($value);

        $program
            ->applyAggregate($programAggregate)
            ->save();

        ProgramActiveUpdated::dispatch($program);

        return $program;
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
