<?php

namespace Tests\Api\Feature\Account;

use App\Models\User;
use CardzApp\Api\Shared\Routes;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Hash;
use Tests\Api\Feature\FeatureTestTrait;
use Tests\TestCase;

class UpdateOwnUserTest extends TestCase
{
    private const ROUTE = Routes::ACCOUNT_UPDATE_OWN_USER;

    use FeatureTestTrait;

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

        $result = User::query()->findOrFail($user->id);
        $this->assertTrue(
            Hash::check(UserFactory::$password . '!', $result->password)
        );
        $this->assertEquals($user->username . '!', $result->username);

    }
}
