<?php

namespace CardzApp\Api\Collect\Controllers\Card;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Collect\Application\Services\CardService;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Illuminate\Http\Request;

class RejectCardController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private CardService $cardService,
    )
    {
    }

    public function __invoke(Request $request)
    {
        $this->cardService->rejectCard(
            Uuid::of($request->card)
        );

        return $this->successResponse();
    }
}
