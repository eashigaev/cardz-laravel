<?php

namespace Codderz\YokoLite\Application\Auth;

use Illuminate\Contracts\Auth\Access\Gate;
use function app;

trait GateTestTrait
{
    public function gate(): Gate
    {
        return app()->make(Gate::class);
    }

    public function skipAuthorization()
    {
        return \Gate::partialMock()->expects('authorize');
    }

    public function assertAuthorizationAbility(string $ability)
    {
        $this->assertContains($ability, $this->gate()->abilities());
    }

    //

    public function assertAuthorizedRoute(string $routeName, string $ability)
    {
        $pattern = '/^' . Auth::CAN_MIDDLEWARE . ':' . $ability . '[$,]/';
        $this->assertRouteMatchesMiddleware($routeName, $pattern);
        $this->assertAuthorizationAbility($ability);
        return $this;
    }
}
