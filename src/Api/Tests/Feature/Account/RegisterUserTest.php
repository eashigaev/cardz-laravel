<?php

namespace CardzApp\Api\Tests\Feature\Account;

use App\Models\User;
use CardzApp\Api\Shared\Presentation\Routes;
use CardzApp\Api\Tests\Support\ModuleTestTrait;
use Database\Factories\UserFactory;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    private const ROUTE = Routes::ACCOUNT_REGISTER_USER_ACTION;

    use ModuleTestTrait;

    public function test_action()
    {
        $user = User::factory()->make();

        $response = $this->callJsonRoute(self::ROUTE, [
            'username' => $user->username,
            'password' => UserFactory::$password,
            'email' => $user->email
        ]);
        $response->assertStatus(200);

        $result = User::query()->firstOrFailWhereCredentials(
            $user->username, UserFactory::$password
        );
        $this->assertArraySubset([
            'id' => $response['id'],
            'email' => $user->email
        ], $result->toArray());
    }
}
