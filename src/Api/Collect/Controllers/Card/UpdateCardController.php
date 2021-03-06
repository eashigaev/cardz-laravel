<?php

namespace CardzApp\Api\Collect\Controllers\Card;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Collect\Application\Services\CardService;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Illuminate\Http\Request;

class UpdateCardController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private CardService $cardService,
    )
    {
    }

    public function __invoke(Request $request)
    {
        $this->cardService->updateCard(
            Uuid::of($request->card), $request->comment
        );

        return $this->successResponse();
    }
}
