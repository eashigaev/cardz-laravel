<?php

namespace CardzApp\Api\Collect\Controllers\Program;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Collect\Application\Services\ProgramService;
use CardzApp\Modules\Collect\Domain\ProgramProfile;
use CardzApp\Modules\Collect\Domain\ProgramReward;
use Illuminate\Http\Request;

class AddProgramController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private ProgramService $programService
    )
    {
    }

    public function __invoke(Request $request)
    {
        $profile = ProgramProfile::of(
            $request->title, $request->description
        );

        $reward = ProgramReward::of(
            $request->reward_title, $request->reward_target
        );

        $programId = $this->programService->addProgram(
            $request->company, $profile, $reward
        );

        return $this->successResponse([
            'id' => $programId
        ]);
    }
}
