<?php

namespace CardzApp\Api\Collect\Application\Subscribers;

use CardzApp\Api\Collect\Application\Events\ProgramActiveUpdated;

class CollectSubscriber
{
    public function onProgramActiveUpdated(ProgramActiveUpdated $event)
    {

    }

    public function subscribe()
    {
        return [
            ProgramActiveUpdated::class => 'onProgramActiveUpdated',
        ];
    }
}
