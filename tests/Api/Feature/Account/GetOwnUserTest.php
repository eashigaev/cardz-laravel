<?php

namespace Tests\Api\Feature\Account;

use App\Models\User;
use CardzApp\Api\Shared\Presentation\Routes;
use Tests\Api\Support\ModuleTestTrait;
use Tests\TestCase;

class GetOwnUserTest extends TestCase
{
    private const ROUTE = Routes::ACCOUNT_GET_OWN_USER;

    use ModuleTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
    }

    public function test_action()
    {
        $user = User::factory()->create();

        $this->actingAsSanctum($user);

        $response = $this->callJsonRoute(self::ROUTE);
        $response->assertStatus(200);
        $response->assertJsonStructure(
            ['id', 'username', 'email', 'createdAt']
        );

        $this->assertArraySubset([
            'id' => $user->id,
            'email' => $user->email,
            'username' => $user->username,
        ], $response->json());
    }
}
