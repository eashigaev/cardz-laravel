<?php

namespace Tests\Api\Feature\Collect\Achievement;

use App\Models\Collect\Achievement;
use App\Models\Collect\Card;
use App\Models\Collect\Task;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Collect\Application\Events\CardAchievementsChanged;
use CardzApp\Modules\Collect\Domain\CardStatus;
use CardzApp\Modules\Shared\Application\Actions;
use Illuminate\Support\Facades\Event;
use Tests\Api\Support\FeatureTestTrait;
use Tests\TestCase;

class AddAchievementTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_ADD_ACHIEVEMENT;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_ADD_ACHIEVEMENT);
    }

    public function test_action()
    {
        $task = Task::factory()->create(['active' => true, 'repeatable' => true]);
        $task->program()->update(['active' => true, 'reward_target' => 5]);

        dd($task->company_id, $task->program->company_id);

        $card = Card::factory()->for($task->program)->for($task->company)
            ->withStatus(CardStatus::ACTIVE)->create(['balance' => 0]);

        Achievement::factory()->for($card)->count(3)->create();

        $this->actingAsCompany($card->company);

        Event::fake();

        $response = $this->callJsonRoute(self::ROUTE,
            ['task' => $task->id],
            ['card' => $card->id]
        );
        $response->assertStatus(200);

        $result = Achievement::query()->findOrFail($response['id']);
        $this->assertArraySubset([
            'company_id' => $card->company->id,
            'program_id' => $card->program->id,
            'task_id' => $task->id,
            'card_id' => $card->id,
        ], $result->toArray());

        Event::assertDispatched(CardAchievementsChanged::class);
    }
}
