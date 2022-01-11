<?php

namespace CardzApp\Api\Collect\Controllers\Achievement;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Collect\Application\Services\AchievementService;
use Illuminate\Http\Request;

class RemoveAchievementController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private AchievementService $achievementService,
    )
    {
    }

    public function __invoke(Request $request)
    {
        $this->achievementService->removeAchievement(
            $request->achievement
        );

        return $this->successResponse();
    }
}
