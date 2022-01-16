<?php

namespace CardzApp\Api\Collect\Controllers\Card;

use App\Http\Controllers\Controller;
use CardzApp\Api\Collect\Transformers\CardTransformer;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Collect\Application\Services\CardService;
use Illuminate\Http\Request;

class GetCardController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private CardService     $cardService,
        private CardTransformer $cardTransformer
    )
    {
    }

    public function __invoke(Request $request)
    {
        $item = $this->cardService->getCard($request->card);

        return $this->successResponse(
            $this->cardTransformer->detail($item)
        );
    }
}
