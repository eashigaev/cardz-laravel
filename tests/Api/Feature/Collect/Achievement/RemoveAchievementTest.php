<?php

namespace Tests\Api\Feature\Collect\Achievement;

use App\Models\Collect\Achievement;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Collect\Application\Events\CardAchievementsChanged;
use CardzApp\Modules\Collect\Domain\CardStatus;
use CardzApp\Modules\Collect\Domain\Messages;
use CardzApp\Modules\Shared\Application\Actions;
use Illuminate\Support\Facades\Event;
use Tests\Api\Support\FeatureTestTrait;
use Tests\TestCase;

class RemoveAchievementTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_REMOVE_ACHIEVEMENT;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_REMOVE_ACHIEVEMENT);
    }

    public function test_action()
    {
        $achievement = Achievement::factory()->create();
        $achievement->card()->update(['status' => CardStatus::ACTIVE->getValue()]);
        $achievement->program()->update(['active' => true]);

        $this->actingAsCompany($achievement->company);

        Event::fake();

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'achievement' => $achievement->id
        ]);
        $response->assertStatus(200);

        $this->assertNull(Achievement::query()->find($achievement->id));

        Event::assertDispatched(CardAchievementsChanged::class);
    }

    public function test_fail_when_non_active_card()
    {
        $achievement = Achievement::factory()->create();
        $achievement->card()->update(['status' => CardStatus::REWARDED->getValue()]);

        $this->actingAsCompany($achievement->company);

        $this->withoutExceptionHandling();
        $this->expectExceptionMessage(Messages::CARD_IS_NOT_ACTIVE);

        $this->callJsonRoute(self::ROUTE, parameters: [
            'achievement' => $achievement->id
        ]);
    }
}
