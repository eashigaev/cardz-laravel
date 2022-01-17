<?php

namespace Tests\Feature\Api\Collect\Achievement;

use App\Models\Collect\Achievement;
use App\Models\Collect\Card;
use App\Models\Collect\Task;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Collect\Domain\CardStatus;
use CardzApp\Modules\Shared\Application\Actions;
use Tests\Feature\Api\FeatureTestTrait;
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
        $task = Task::factory()->create(['active' => 1]);
        $task->program()->update(['active' => true, 'reward_target' => 2]);

        $card = Card::factory()->withStatus(CardStatus::ACTIVE)->forProgram($task->program)->create();
        Achievement::factory()->for($card)->create();

        $this->actingAsCompany($card->company);

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
    }
}
