<?php

namespace CardzApp\Api\Collect\Application\Listeners;

use CardzApp\Api\Collect\Application\Events\ProgramActiveUpdated;
use CardzApp\Api\Collect\Application\Services\CardService;

class BatchUpdateCardProgramActive
{
    public function __construct(
        private CardService $cardService
    )
    {
    }

    public function __invoke(ProgramActiveUpdated $event)
    {
        $this->cardService->batchUpdateCardProramActive(
            $event->program->id, $event->program->active
        );
    }
}
