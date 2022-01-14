<?php

namespace CardzApp\Api\Collect\Controllers\Card;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Collect\Application\Services\CardService;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Illuminate\Http\Request;

class IssueCardController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private CardService $cardService,
    )
    {
    }

    public function __invoke(Request $request)
    {
        $cardId = $this->cardService->issueCard(
            Uuid::of($request->program),
            Uuid::of($request->holder),
            $request->comment
        );

        return $this->successResponse([
            'id' => $cardId
        ]);
    }
}
