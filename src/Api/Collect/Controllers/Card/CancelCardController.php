<?php

namespace CardzApp\Api\Collect\Controllers\Card;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Collect\Application\Services\CardService;
use Illuminate\Http\Request;

class CancelCardController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private CardService $cardService,
    )
    {
    }

    public function __invoke(Request $request)
    {
        $this->cardService->cancelCard(
            $request->card
        );

        return $this->successResponse();
    }
}