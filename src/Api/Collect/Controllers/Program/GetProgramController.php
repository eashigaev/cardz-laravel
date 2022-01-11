<?php

namespace CardzApp\Api\Collect\Controllers\Program;

use App\Http\Controllers\Controller;
use CardzApp\Api\Collect\Transformers\ProgramTransformer;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Collect\Application\Services\ProgramService;
use Illuminate\Http\Request;

class GetProgramController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private ProgramService     $programService,
        private ProgramTransformer $programTransformer
    )
    {
    }

    public function __invoke(Request $request)
    {
        $item = $this->programService->getProgram(
            $request->program
        );

        return $this->successResponse(
            $this->programTransformer->detail($item)
        );
    }
}
