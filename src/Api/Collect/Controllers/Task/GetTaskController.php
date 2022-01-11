<?php

namespace CardzApp\Api\Collect\Controllers\Task;

use App\Http\Controllers\Controller;
use CardzApp\Api\Collect\Transformers\TaskTransformer;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Collect\Application\Services\TaskService;
use Illuminate\Http\Request;

class GetTaskController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private TaskService            $taskService,
        private TaskTransformer $taskTransformer
    )
    {
    }

    public function __invoke(Request $request)
    {
        $item = $this->taskService->getProgramTask(
            $request->task
        );

        return $this->successResponse(
            $this->taskTransformer->detail($item)
        );
    }
}
