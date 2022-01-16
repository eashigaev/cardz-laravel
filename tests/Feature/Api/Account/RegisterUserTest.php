<?php

namespace Tests\Feature\Api\Account;

use App\Models\User;
use CardzApp\Api\Shared\Routes;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Hash;
use Tests\Feature\Api\FeatureTestTrait;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    private const ROUTE = Routes::ACCOUNT_REGISTER_USER;

    use FeatureTestTrait;

    public function test_action()
    {
        $user = User::factory()->make();

        $response = $this->callJsonRoute(self::ROUTE, [
            'username' => $user->username,
            'password' => UserFactory::$password,
            'email' => $user->email
        ]);
        $response->assertStatus(200);

        $result = User::query()->findOrFail($response['id']);
        $this->assertTrue(
            Hash::check(UserFactory::$password, $result->password)
        );
        $this->assertArraySubset([
            'username' => $user->username,
            'email' => $user->email
        ], $result->toArray());
    }
}
