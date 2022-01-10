<?php

namespace CardzApp\Api\Collect\Presentation\Controllers\Task;

use App\Http\Controllers\Controller;
use CardzApp\Api\Collect\Application\Services\TaskService;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class UpdateTaskActiveController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private TaskService $taskService,
    )
    {
    }

    public function __invoke(Request $request)
    {
        $this->taskService->updateProgramTaskActive(
            $request->task, $request->value
        );

        return $this->successResponse();
    }
}
