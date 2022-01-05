<?php

namespace CardzApp\Api\Collect\Presentation\Controllers\Program;

use App\Http\Controllers\Controller;
use CardzApp\Api\Collect\Application\Services\ProgramService;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class UpdateProgramAvailableController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private ProgramService $programService
    )
    {
    }

    public function __invoke(Request $request)
    {
        $this->programService->updateProgramAvailability(
            $request->program, $request->value
        );

        return $this->successResponse();
    }
}
