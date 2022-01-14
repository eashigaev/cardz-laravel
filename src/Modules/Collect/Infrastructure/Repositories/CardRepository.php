<?php

namespace CardzApp\Modules\Collect\Infrastructure\Repositories;

use App\Models\Collect\Card;
use CardzApp\Modules\Collect\Domain\CardAggregate;
use CardzApp\Modules\Collect\Domain\CardStatus;
use Codderz\YokoLite\Domain\Uuid\Uuid;

class CardRepository
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
        )
            ->withMetaVersion($card->meta_version);
    }

    public function create(CardAggregate $aggregate)
    {
        Card::query()->insert([
            'id' => $aggregate->id->getValue(),
            'company_id' => $aggregate->companyId->getValue(),
            'program_id' => $aggregate->programId->getValue(),
            'holder_id' => $aggregate->holderId->getValue(),
            'comment' => $aggregate->comment,
            'balance' => $aggregate->balance,
            'status' => $aggregate->status->getValue(),
            'meta_version' => $aggregate->nextMetaVersion()
        ]);
    }

    public function update(CardAggregate $aggregate)
    {
        Card::query()->where([
            'id' => $aggregate->id->getValue(),
            'meta_version' => $aggregate->getMetaVersion()
        ])->update([
            'comment' => $aggregate->comment,
            'balance' => $aggregate->balance,
            'status' => $aggregate->status->getValue(),
            'meta_version' => $aggregate->nextMetaVersion()
        ]);
    }
}
