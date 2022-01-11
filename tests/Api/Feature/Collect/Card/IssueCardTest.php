<?php

namespace Tests\Api\Feature\Collect\Card;

use App\Models\Collect\Card;
use App\Models\User;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Collect\Domain\CardStatus;
use CardzApp\Modules\Collect\Domain\Messages;
use CardzApp\Modules\Shared\Application\Actions;
use Tests\Api\Support\FeatureTestTrait;
use Tests\TestCase;

class IssueCardTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_ISSUE_CARD;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_ISSUE_CARD);
    }

    public function test_action()
    {
        $holder = User::factory()->create();
        $fixture = Card::factory()->make();
        $fixture->program()->update(['active' => true]);

        $user = $fixture->company->founder;
        $this->actingAsSanctum($user);

        $response = $this->callJsonRoute(self::ROUTE, [
            'comment' => $fixture->comment,
            'holder' => $holder->id
        ], [
            'program' => $fixture->program->id
        ]);
        $response->assertStatus(200);

        $result = Card::query()->findOrFail($response['id']);
        $this->assertArraySubset([
            'company_id' => $fixture->company->id,
            'program_id' => $fixture->program->id,
            'holder_id' => $holder->id,
            'balance' => 0,
            'comment' => $fixture->comment,
            'status' => CardStatus::ACTIVE->value
        ], $result->toArray());
    }

    public function test_fail_when_not_active_program()
    {
        $holder = User::factory()->create();
        $fixture = Card::factory()->make();
        $fixture->program()->update(['active' => false]);

        $user = $fixture->company->founder;
        $this->actingAsSanctum($user);

        $this->withoutExceptionHandling();
        $this->expectExceptionMessage(Messages::PROGRAM_IS_NOT_ACTIVE);

        $response = $this->callJsonRoute(self::ROUTE, [
            'comment' => $fixture->comment,
            'program_active' => $fixture->program->active,
            'holder' => $holder->id
        ], [
            'program' => $fixture->program->id
        ]);
        $response->assertStatus(200);
    }
}
