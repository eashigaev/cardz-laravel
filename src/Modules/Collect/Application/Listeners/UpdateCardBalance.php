<?php

namespace CardzApp\Modules\Collect\Application\Listeners;

use CardzApp\Modules\Collect\Application\Events\CardAchievementsChanged;
use CardzApp\Modules\Collect\Application\Services\CardService;

class UpdateCardBalance
{
    public function __construct(
        private CardService $cardService
    )
    {
    }

    public function __invoke(CardAchievementsChanged $event)
    {
        $this->cardService->batchUpdateCardsProramActive(
            $event->program->id, $event->program->active
        );
    }
}
