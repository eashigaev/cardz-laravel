<?php

namespace CardzApp\Api\Tests\Feature\Auth;

use App\Models\User;
use CardzApp\Api\Shared\Presentation\Routes;
use CardzApp\Api\Tests\Support\ModuleTestTrait;
use Database\Factories\UserFactory;
use Tests\TestCase;

class LoginTest extends TestCase
{
    private const ROUTE = Routes::AUTH_LOGIN_ACTION;

    use ModuleTestTrait;

    public function test_action()
    {
        $user = User::factory()->create();

        $response = $this->callJsonRoute(self::ROUTE, [
            'username' => $user->username,
            'password' => UserFactory::$password,
        ]);
        $response->assertStatus(200);

        $this->assertNotNull(
            $this->findSanctumToken($response['token'])
        );
    }
}
