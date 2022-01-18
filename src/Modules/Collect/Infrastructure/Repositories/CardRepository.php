<?php

namespace CardzApp\Modules\Collect\Infrastructure\Repositories;

use App\Models\Collect\Card;
use CardzApp\Modules\Collect\Domain\CardAggregate;
use Codderz\YokoLite\Domain\Uuid\Uuid;

interface CardRepository
{
    public function ofIdOrFail(Uuid $cardId);

    public function ofAchievementIdOrFail(Uuid $achievementId);

    public function of(Card $card): CardAggregate;

    public function save(CardAggregate $aggregate);
}
