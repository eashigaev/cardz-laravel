<?php

namespace CardzApp\Modules\Collect\Application\Services;

use App\Models\Collect\Program;
use App\Models\Company;
use CardzApp\Modules\Collect\Domain\ProgramAggregate;
use CardzApp\Modules\Collect\Domain\ProgramProfile;
use CardzApp\Modules\Collect\Domain\ProgramReward;
use CardzApp\Modules\Collect\Infrastructure\Repositories\ProgramRepository;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Illuminate\Database\Eloquent\Builder;

class ProgramService
{
    public function __construct(
        private UuidGenerator     $uuidGenerator,
        private ProgramRepository $programRepository
    )
    {
    }

    public function addProgram(Uuid $companyId, ProgramProfile $profile, ProgramReward $reward)
    {
        Company::query()->findOrFail($companyId->getValue());

        $aggregate = ProgramAggregate::add(
            Uuid::of($this->uuidGenerator->getNextValue()),
            $companyId,
            $profile,
            $reward
        );

        $this->programRepository->save($aggregate);

        return $aggregate->id->getValue();
    }

    public function updateProgram(Uuid $programId, ProgramProfile $profile, ProgramReward $reward)
    {
        $aggregate = $this->programRepository->ofIdOrFail($programId);

        $aggregate->update($profile, $reward);

        $this->programRepository->save($aggregate);
    }

    public function updateProgramActive(Uuid $programId, bool $value)
    {
        $aggregate = $this->programRepository->ofIdOrFail($programId);

        $aggregate->updateActive($value);

        $this->programRepository->save($aggregate);
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
