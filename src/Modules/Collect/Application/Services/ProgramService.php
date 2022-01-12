<?php

namespace CardzApp\Modules\Collect\Application\Services;

use App\Models\Collect\Program;
use App\Models\Company;
use CardzApp\Modules\Collect\Application\Events\ProgramActiveUpdated;
use CardzApp\Modules\Collect\Domain\ProgramAggregate;
use CardzApp\Modules\Collect\Domain\ProgramProfile;
use CardzApp\Modules\Collect\Domain\ProgramReward;
use CardzApp\Modules\Collect\Infrastructure\Mediators\CompanyMediator;
use CardzApp\Modules\Collect\Infrastructure\Mediators\ProgramMediator;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Illuminate\Database\Eloquent\Builder;

class ProgramService
{
    public function __construct(
        private UuidGenerator   $uuidGenerator,
        private CompanyMediator $companyMediator,
        private ProgramMediator $programMediator
    )
    {
    }

    public function addProgram(string $companyId, ProgramProfile $profile, ProgramReward $reward)
    {
        $company = Company::query()->findOrFail($companyId);

        $aggregate = ProgramAggregate::add(
            Uuid::of($this->uuidGenerator->getNextValue()),
            $this->companyMediator->of($company),
            $profile,
            $reward
        );
        $this->programMediator->save($aggregate);

        return $aggregate->id->getValue();
    }

    public function updateProgram(string $programId, ProgramProfile $profile, ProgramReward $reward)
    {
        $program = Program::query()->findOrFail($programId);

        $aggregate = $this->programMediator->of($program);
        $aggregate->update($profile, $reward);
        $this->programMediator->save($aggregate);
    }

    public function updateProgramActive(string $programId, bool $value)
    {
        $program = Program::query()->findOrFail($programId);

        $aggregate = $this->programMediator->of($program);
        $aggregate->updateActive($value);
        $this->programMediator->save($aggregate);

        ProgramActiveUpdated::dispatch($program->refresh());
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
