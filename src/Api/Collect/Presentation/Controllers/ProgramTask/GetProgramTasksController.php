<?php

namespace CardzApp\Api\Collect\Presentation\Controllers\ProgramTask;

use App\Http\Controllers\Controller;
use CardzApp\Api\Collect\Application\Services\ProgramTaskService;
use CardzApp\Api\Collect\Presentation\Transformers\ProgramTaskTransformer;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class GetProgramTasksController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private ProgramTaskService     $programTaskService,
        private ProgramTaskTransformer $programTaskTransformer
    )
    {
    }

    public function __invoke(Request $request)
    {
        $items = $this->programTaskService
            ->getProgramTasks($request->program)
            ->map(fn($i) => $this->programTaskTransformer->preview($i));

        return $this->successResponse($items);
    }
}
