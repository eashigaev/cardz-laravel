<?php

namespace CardzApp\Api\Collect\Controllers\Achievement;

use App\Http\Controllers\Controller;
use App\Models\Collect\Achievement;
use CardzApp\Api\Collect\Transformers\AchievementTransformer;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Collect\Application\Services\AchievementService;
use Illuminate\Http\Request;

class GetAchievementsController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private AchievementService     $achievementService,
        private AchievementTransformer $achievementTransformer
    )
    {
    }

    public function __invoke(Request $request)
    {
        $items = $this->achievementService
            ->getAchievements($request->card)
            ->map(fn(Achievement $item) => $this->achievementTransformer->transform($item));

        return $this->successResponse(
            $items
        );
    }
}
