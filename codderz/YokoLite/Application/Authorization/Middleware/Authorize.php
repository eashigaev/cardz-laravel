<?php

namespace Codderz\YokoLite\Application\Authorization\Middleware;

use Closure;
use Codderz\YokoLite\Application\Authorization\Authorization;
use Codderz\YokoLite\Shared\Utils\Json;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\Request;

class Authorize
{
    public function __construct(
        private Gate $gate
    )
    {
    }

    public static function for(string $ability, array $resources = []): string
    {
        $middleware = Authorization::MIDDLEWARE . ':' . $ability;
        if ($resources) {
            $middleware .= ',' . Json::to($resources);
        }
        return $middleware;
    }

    public function handle(Request $request, Closure $next, string $ability, string $resources = '')
    {
        $objects = $this->parseResources($request, $resources);

        $payload = $request->collect()->merge(
            $request->route()->parameters()
        );

        $this->gate->authorize($ability, [...$objects, $payload]);

        return $next($request);
    }

    public function parseResources(Request $request, string $resources)
    {
        if (!$decoded = Json::from($resources)) {
            return [];
        };

        $result = [];
        foreach ($decoded as $property => $model) {
            $id = !empty($property) ? $request->$property : $request->user()?->id;

            $result[] = is_subclass_of($model, Authorizable::class)
                ? $model::authorizableOrFail($id)
                : $model::findOrFail($id);
        }

        return $result;
    }
}
