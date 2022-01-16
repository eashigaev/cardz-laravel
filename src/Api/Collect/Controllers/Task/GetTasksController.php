<?php

namespace CardzApp\Api\Collect\Controllers\Task;

use App\Http\Controllers\Controller;
use CardzApp\Api\Collect\Transformers\TaskTransformer;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Collect\Application\Services\TaskService;
use Illuminate\Http\Request;

class GetTasksController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private TaskService     $taskService,
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
