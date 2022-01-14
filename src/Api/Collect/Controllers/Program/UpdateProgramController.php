<?php

namespace CardzApp\Api\Collect\Controllers\Program;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Collect\Application\Services\ProgramService;
use CardzApp\Modules\Collect\Domain\ProgramProfile;
use CardzApp\Modules\Collect\Domain\ProgramReward;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Illuminate\Http\Request;

class UpdateProgramController extends Controller
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

        $this->programService->updateProgram(
            Uuid::of($request->program), $profile, $reward
        );

        return $this->successResponse();
    }
}
