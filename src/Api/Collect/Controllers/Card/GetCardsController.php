<?php

namespace CardzApp\Api\Collect\Controllers\Card;

use App\Http\Controllers\Controller;
use App\Models\Collect\Card;
use CardzApp\Api\Collect\Transformers\CardTransformer;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Collect\Application\Services\CardService;
use Illuminate\Http\Request;

class GetCardsController extends Controller
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
        $items = $this->cardService
            ->getCards($request->program)
            ->map(fn(Card $item) => $this->cardTransformer->preview($item));

        return $this->successResponse(
            $items
        );
    }
}
