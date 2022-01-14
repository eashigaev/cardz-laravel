<?php

namespace CardzApp\Api\Collect\Controllers\Program;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Collect\Application\Services\ProgramService;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Illuminate\Http\Request;

class UpdateProgramActiveController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private ProgramService $programService
    )
    {
    }

    public function __invoke(Request $request)
    {
        $this->programService->updateProgramActive(
            Uuid::of($request->program), $request->value
        );

        return $this->successResponse();
    }
}
