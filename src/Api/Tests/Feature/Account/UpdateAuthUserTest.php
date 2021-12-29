<?php

namespace CardzApp\Api\Tests\Feature\Account;

use App\Models\User;
use CardzApp\Api\Shared\Presentation\Routes;
use CardzApp\Api\Tests\Support\ModuleTestTrait;
use Database\Factories\UserFactory;
use Tests\TestCase;

class UpdateAuthUserTest extends TestCase
{
    private const ROUTE = Routes::ACCOUNT_UPDATE_AUTH_USER_ACTION;

    use ModuleTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
    }

    public function test_action()
    {
        $user = User::factory()->create();
        $this->actingAsSanctum($user);

        $response = $this->callJsonRoute(self::ROUTE, [
            'username' => $user->username . '!',
            'password' => UserFactory::$password . '!'
        ]);
        $response->assertStatus(200);

        $result = User::query()->firstOrFailWhereCredentials(
            $user->username . '!', UserFactory::$password . '!'
        );
        $this->assertArraySubset([
            'id' => $user->id,
        ], $result->toArray());
    }
}
