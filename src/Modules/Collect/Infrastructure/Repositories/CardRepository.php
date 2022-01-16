<?php

namespace CardzApp\Modules\Collect\Infrastructure\Repositories;

use App\Models\Collect\Achievement;
use App\Models\Collect\Card;
use CardzApp\Modules\Collect\Domain\AchievementEntity;
use CardzApp\Modules\Collect\Domain\CardAggregate;
use CardzApp\Modules\Collect\Domain\CardStatus;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Codderz\YokoLite\Infrastructure\Database\PersistenceTrait;
use Codderz\YokoLite\Infrastructure\Registry\Registry;

class CardRepository
{
    use PersistenceTrait;

    public function __construct(private Registry $registry)
    {
    }

    public function ofIdOrFail(Uuid $cardId)
    {
        $model = Card::query()->with('achievements')->findOrFail($cardId->getValue());

        return $this->of($model);
    }

    public function ofAchievementIdOrFail(Uuid $achievementId)
    {
        $model = Achievement::query()->with('card', 'card.achievements')->findOrFail($achievementId->getValue());

        return $this->of($model->program);
    }

    public function of(Card $card): CardAggregate
    {
        $this->registry->set($card->id, $card);

        $achievements = $card->achievements->map(fn(Achievement $item) => AchievementEntity::of(
            Uuid::of($item->id),
            Uuid::of($item->task_id)
        ));

        return CardAggregate::of(
            Uuid::of($card->id),
            Uuid::of($card->company_id),
            Uuid::of($card->program_id),
            Uuid::of($card->holder_id),
            $card->comment,
            CardStatus::from($card->status),
            $achievements
        );
    }

    //

    public function save(CardAggregate $aggregate)
    {
        $card = $this->registry->get($aggregate->id->getValue(), Card::make());

        $this->execute(function () use ($aggregate, $card) {
            $this->saveCard($aggregate, $card);
            $this->syncAchievements($aggregate, $card);
        });
    }

    private function saveCard(CardAggregate $aggregate, Card $card)
    {
        $card->forceFill([
            'id' => $aggregate->id->getValue(),
            'company_id' => $aggregate->companyId->getValue(),
            'program_id' => $aggregate->programId->getValue(),
            'holder_id' => $aggregate->holderId->getValue(),
            'comment' => $aggregate->comment,
            'status' => $aggregate->status->getValue(),
            'balance' => $aggregate->getBalance(),
        ]);
        $card->save();
    }

    private function syncAchievements(CardAggregate $aggregate, Card $card)
    {
        $items = $aggregate->achievements->map(fn(AchievementEntity $item) => [
            'id' => $item->id->getValue(),
            'company_id' => $aggregate->companyId->getValue(),
            'program_id' => $aggregate->programId->getValue(),
            'task_id' => $item->taskId->getValue(),
            'card_id' => $aggregate->id->getValue(),
        ]);
        $card->achievements()->sync($items->toArray());
    }
}
