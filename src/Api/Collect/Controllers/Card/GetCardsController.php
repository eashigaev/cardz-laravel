<?php

namespace CardzApp\Api\Collect\Controllers\Card;

use App\Http\Controllers\Controller;
use App\Models\Collect\Card;
use CardzApp\Api\Collect\Transformers\CardTransformer;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Api\Shared\Transformers\PaginatorTransformer;
use CardzApp\Modules\Collect\Application\Services\CardService;
use Illuminate\Http\Request;

class GetCardsController extends Controller
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

        $paginator = $this->cardService->getCards($request->program, $page);

        return $this->successResponse(
            $this->paginatorTransformer->transform(
                $paginator,
                fn(Card $item) => $this->cardTransformer->preview($item)
            )
        );
    }
}
