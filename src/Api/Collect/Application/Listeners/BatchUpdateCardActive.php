<?php

namespace CardzApp\Api\Collect\Application\Listeners;

use CardzApp\Api\Collect\Application\Events\ProgramActiveUpdated;
use CardzApp\Api\Collect\Application\Services\CardService;
use CardzApp\Api\Collect\Domain\CardStatus;

class BatchUpdateCardActive
{
    public function __construct(
        private CardService $cardService
    )
    {
    }

    public function __invoke(ProgramActiveUpdated $event)
    {
        $this->cardService->batchUpdateCardActive(
            $event->getProgram()->id,
            $event->getProgram()->active ? CardStatus::ACTIVE : CardStatus::INACTIVE
        );
    }
}
