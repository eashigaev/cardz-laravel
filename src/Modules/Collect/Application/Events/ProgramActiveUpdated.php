<?php

namespace CardzApp\Modules\Collect\Application\Events;

use App\Models\Collect\Program;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProgramActiveUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Program $program)
    {
    }
}
