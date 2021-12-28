<?php

namespace CardzApp\Api\Collect\Application;

use App\Models\Collect\Program;
use App\Models\Company;
use App\Models\User;
use CardzApp\Api\Shared\Application\Actions;

class CollectBootstrap
{
    public function getPolicies()
    {
        return [
            Actions::COLLECT_ADD_PROGRAM =>
                fn(User $sub, Company $res) => $sub->id === $res->founder_id,
            Actions::COLLECT_UPDATE_PROGRAM =>
                fn(User $sub, Program $res) => $sub->id === $res->company->founder_id,
            Actions::COLLECT_UPDATE_PROGRAM_AVAILABILITY =>
                fn(User $sub, Program $res) => $sub->id === $res->company->founder_id,
        ];
    }
}
