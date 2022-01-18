<?php

namespace CardzApp\Api\Wallet\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Api\Wallet\Transformers\CardTransformer;
use CardzApp\Modules\Wallet\Application\Services\CardService;
use Illuminate\Http\Request;

class GetOwnCardController extends Controller
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
        $item = $this->cardService->getOwnCard(
            $request->user()->id, $request->card
        );

        return $this->successResponse(
            $this->cardTransformer->detail($item)
        );
    }
}
