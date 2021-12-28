<?php

namespace Codderz\YokoLite\Application\Authentication;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Laravel\Sanctum\Sanctum;

trait SanctumTestTrait
{
    public function actingAsSanctum(Model|User $user)
    {
        Sanctum::actingAs($user);
    }

    public function findSanctumToken($token)
    {
        return Sanctum::personalAccessTokenModel()::findToken($token);
    }

    public function getSanctumTokensCount()
    {
        return Sanctum::personalAccessTokenModel()::count();
    }

    //

    public function assertAuthenticatedRoute(string $routeName)
    {
        $this->assertRouteContainsMiddleware($routeName, Authentication::MIDDLEWARE);
        return $this;
    }
}
