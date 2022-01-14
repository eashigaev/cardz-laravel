<?php

namespace CardzApp\Api\Collect\Controllers\Task;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Collect\Application\Services\TaskService;
use CardzApp\Modules\Collect\Domain\TaskFeature;
use CardzApp\Modules\Collect\Domain\TaskProfile;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Illuminate\Http\Request;

class UpdateTaskController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private TaskService $taskService,
    )
    {
    }

    public function __invoke(Request $request)
    {
        $profile = TaskProfile::of(
            $request->title, $request->description
        );

        $feature = TaskFeature::of(
            $request->repeatable
        );

        $this->taskService->updateTask(
            Uuid::of($request->task), $profile, $feature
        );

        return $this->successResponse();
    }
}
