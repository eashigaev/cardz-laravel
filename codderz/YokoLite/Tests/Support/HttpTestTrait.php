<?php

namespace Codderz\YokoLite\Tests\Support;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Testing\TestResponse;
use function route;

trait HttpTestTrait
{
    use PhpUnitTestTrait;

    public function callJsonRoute(string $name, array $data = [], array $parameters = []): TestResponse
    {
        $route = $this->getRouteByName($name);
        $method = $route->methods()[0];
        $url = route($name, $parameters);

        return $this->json($method, $url, $data);
    }

    //

    public function getRouteByName(string $name): Route
    {
        $route = $this->router()->getRoutes()->getByName($name);

        if (!$route) {
            $this->fail("Route with name [{$name}] not found!");
        }

        return $route;
    }

    //

    public function getRouteMiddleware(string $name): array
    {
        $route = $this->getRouteByName($name);

        return array_diff($route->middleware(), $route->excludedMiddleware());
    }

    public function assertRouteContainsMiddleware(string $name, string $middleware)
    {
        $this->assertContains(
            $middleware, $this->getRouteMiddleware($name), "Route doesn't contain an middleware [$name]"
        );
    }

    public function assertRouteMatchesMiddleware(string $name, string $pattern)
    {
        $this->assertArrayMatches($pattern, $this->getRouteMiddleware($name));
    }

    public function assertRouteNotContainsMiddleware(string $name, string $middleware)
    {
        $this->assertNotContains(
            $middleware, $this->getRouteMiddleware($name), "Route contains an middleware [$name]"
        );
    }

    public function assertRouteNotMatchesMiddleware(string $name, string $pattern)
    {
        $this->assertArrayNotMatches($pattern, $this->getRouteMiddleware($name));
    }

    //

    public function router(): Router
    {
        return app()->make(Router::class);
    }
}
