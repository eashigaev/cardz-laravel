<?php

namespace CardzApp\Api\Collect\Presentation\Controllers\Task;

use App\Http\Controllers\Controller;
use CardzApp\Api\Collect\Application\Services\TaskService;
use CardzApp\Api\Collect\Domain\TaskFeature;
use CardzApp\Api\Collect\Domain\TaskProfile;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class AddTaskController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private TaskService $taskService,
    )
    {
    }

    public function __invoke(Request $request)
    {
        $profile = TaskProfile::of($request->title, $request->description);

        $feature = TaskFeature::of($request->repeatable);

        $taskId = $this->taskService->addProgramTask($request->program, $profile, $feature);

        return $this->successResponse([
            'id' => $taskId
        ]);
    }
}
