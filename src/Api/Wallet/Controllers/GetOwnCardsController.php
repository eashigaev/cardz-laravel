<?php

namespace CardzApp\Api\Wallet\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Collect\Card;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Api\Shared\Transformers\PaginatorTransformer;
use CardzApp\Api\Wallet\Transformers\CardTransformer;
use CardzApp\Modules\Wallet\Application\Services\CardService;
use Illuminate\Http\Request;

class GetOwnCardsController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private CardService          $cardService,
        private CardTransformer      $cardTransformer,
        private PaginatorTransformer $paginatorTransformer
    )
    {
    }

    public function __invoke(Request $request)
    {
        $page = $request->page ?? 1;

        $paginator = $this->cardService->getOwnCards(
            $request->user()->id, $page
        );

        return $this->successResponse(
            $this->paginatorTransformer->transform(
                $paginator,
                fn(Card $item) => $this->cardTransformer->preview($item)
            )
        );
    }
}
