<?php

namespace CardzApp\Modules\Collect\Application\Events;

use App\Models\Collect\Card;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CardAchievementsChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Card $card)
    {
    }
}
