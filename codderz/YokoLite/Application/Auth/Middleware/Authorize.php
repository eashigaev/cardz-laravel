<?php

namespace Codderz\YokoLite\Application\Auth\Middleware;

use Closure;
use Codderz\YokoLite\Shared\Utils\Json;
use Illuminate\Auth\Middleware\Authorize as BaseAuthorize;
use Illuminate\Support\Arr;

class Authorize extends BaseAuthorize
{
    public function handle($request, Closure $next, $ability, ...$models)
    {
        $arguments = $this->getGateArguments($request, $models);

        $arguments = $this->parseResources($request, $arguments);

        $payload = $request->collect()->merge(
            $request->route()->parameters()
        );

        $this->gate->authorize($ability, [...$arguments, $payload]);

        return $next($request);
    }

    public function parseResources($request, array $arguments)
    {
        foreach ($arguments as &$argument) {
            $resources = Json::from($argument ?? false);
            if (Json::error()) continue;

            $argument = [];
            foreach ($resources as $property => $model) {
                $id = empty($property) ? $request->user()?->id : $request->$property;
                $argument[] = $model::findOrFail($id);
            }
        }
        return Arr::flatten($arguments);
    }
}
