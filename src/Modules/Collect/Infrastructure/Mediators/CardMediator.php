<?php

namespace CardzApp\Modules\Collect\Infrastructure\Mediators;

use App\Models\Collect\Card;
use CardzApp\Modules\Collect\Domain\CardAggregate;
use CardzApp\Modules\Collect\Domain\CardStatus;
use Codderz\YokoLite\Domain\Uuid\Uuid;

class CardMediator
{
    public function of(Card $card): CardAggregate
    {
        return CardAggregate::of(
            Uuid::of($card->id),
            Uuid::of($card->company_id),
            Uuid::of($card->program_id),
            Uuid::of($card->holder_id),
            $card->comment,
            $card->balance,
            CardStatus::from($card->status)
        );
    }

    public function save(CardAggregate $aggregate)
    {
        $card = Card::firstOrNew();
        $card->id = $aggregate->id->getValue();
        $card->company_id = $aggregate->companyId->getValue();
        $card->program_id = $aggregate->programId->getValue();
        $card->comment = $aggregate->comment;
        $card->balance = $aggregate->balance;
        $card->status = $aggregate->status->value;
        if (!$card->exists) {
//            $card->program_active = ;
        }
        $card->save();
    }
}
