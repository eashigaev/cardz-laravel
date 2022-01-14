<?php

namespace CardzApp\Api\Collect\Controllers\Task;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Collect\Application\Services\TaskService;
use Codderz\YokoLite\Domain\Uuid\Uuid;
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
        $this->taskService->updateTaskActive(
            Uuid::of($request->task), $request->value
        );

        return $this->successResponse();
    }
}
