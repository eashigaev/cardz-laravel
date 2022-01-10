<?php

namespace CardzApp\Api\Collect\Presentation\Controllers\Task;

use App\Http\Controllers\Controller;
use CardzApp\Api\Collect\Application\Services\TaskService;
use CardzApp\Api\Collect\Presentation\Transformers\TaskTransformer;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class GetTasksController extends Controller
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
        $items = $this->taskService
            ->getProgramTasks($request->program)
            ->map(fn($i) => $this->taskTransformer->preview($i));

        return $this->successResponse($items);
    }
}
