<?php

namespace CardzApp\Api\Collect\Application\Services;

use App\Http\Controllers\Controller;
use App\Models\Collect\Program;
use App\Models\Company;
use CardzApp\Api\Collect\Domain\ProgramProfile;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;

class ProgramService extends Controller
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
            ->update($profile->toArray());
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
}
