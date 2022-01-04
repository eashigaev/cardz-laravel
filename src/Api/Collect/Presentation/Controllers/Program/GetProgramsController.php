<?php

namespace CardzApp\Api\Collect\Presentation\Controllers\Program;

use App\Http\Controllers\Controller;
use CardzApp\Api\Collect\Application\Services\ProgramService;
use CardzApp\Api\Collect\Presentation\Transformers\ProgramTransformer;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class GetProgramsController extends Controller
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
        $programs = $this->programService
            ->getPrograms($request->company, $request->all())
            ->map(fn($i) => $this->programTransformer->preview($i));

        return $this->successResponse($programs);
    }
}
