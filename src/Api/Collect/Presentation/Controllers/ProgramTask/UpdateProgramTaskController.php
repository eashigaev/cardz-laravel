<?php

namespace CardzApp\Api\Collect\Presentation\Controllers\ProgramTask;

use App\Http\Controllers\Controller;
use CardzApp\Api\Collect\Application\Services\ProgramTaskService;
use CardzApp\Api\Collect\Domain\ProgramTaskFeature;
use CardzApp\Api\Collect\Domain\ProgramTaskProfile;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class UpdateProgramTaskController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private ProgramTaskService $programTaskService,
    )
    {
    }

    public function __invoke(Request $request)
    {
        $profile = ProgramTaskProfile::of(
            $request->title, $request->description
        );

        $feature = ProgramTaskFeature::of(
            $request->repeatable
        );

        $this->programTaskService->updateProgramTask(
            $request->task, $profile, $feature
        );

        return $this->successResponse();
    }
}
