<?php

namespace Tests\Api\Feature\Auth;

use App\Models\User;
use CardzApp\Api\Shared\Presentation\Routes;
use Database\Factories\UserFactory;
use Tests\Api\Support\ModuleTestTrait;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    private const ROUTE = Routes::AUTH_LOGOUT_ACTION;
    private const LOGIN_ROUTE = Routes::AUTH_LOGIN_ACTION;

    use ModuleTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
    }

    public function test_action()
    {
        $user = User::factory()->create();

        $response = $this->callJsonRoute(self::LOGIN_ROUTE, [
            'username' => $user->username,
            'password' => UserFactory::$password,
        ]);
        $this->assertEquals(1, $this->getSanctumTokensCount());

        $this->withToken($response['token']);

        $response = $this->callJsonRoute(self::ROUTE);
        $response->assertStatus(200);
        $this->assertEquals(0, $this->getSanctumTokensCount());
    }
}
