<?php

namespace CardzApp\Modules\Wallet\Application\Services;

use App\Models\Collect\Card;

class CardService
{
    public function getOwnCards(string $ownerId, int $page)
    {
        return Card::query()
            ->with('company', 'program')
            ->where('holder_id', $ownerId)
            ->limit(100)
            ->orderBy('updated_at')
            ->paginate(perPage: 10, page: $page);
    }

    public function getOwnCard(string $ownerId, string $cardId)
    {
        return Card::query()
            ->with('company', 'program', 'achievements', 'achievements.task')
            ->where('holder_id', $ownerId)
            ->findOrFail($cardId);
    }
}
