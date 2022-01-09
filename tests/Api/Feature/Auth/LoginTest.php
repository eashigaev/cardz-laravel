<?php

namespace Tests\Api\Feature\Auth;

use App\Models\User;
use CardzApp\Api\Shared\Presentation\Routes;
use Database\Factories\UserFactory;
use Tests\Api\Support\FeatureTestTrait;
use Tests\TestCase;

class LoginTest extends TestCase
{
    private const ROUTE = Routes::AUTH_LOGIN;

    use FeatureTestTrait;

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
