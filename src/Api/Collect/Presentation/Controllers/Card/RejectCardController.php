<?php

namespace CardzApp\Api\Collect\Presentation\Controllers\Card;

use App\Http\Controllers\Controller;
use CardzApp\Api\Collect\Application\Services\CardService;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
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
            $request->card
        );

        return $this->successResponse();
    }
}
