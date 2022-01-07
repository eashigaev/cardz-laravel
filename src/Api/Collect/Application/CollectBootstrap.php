<?php

namespace CardzApp\Api\Collect\Application;

use App\Models\Collect\Program;
use App\Models\Collect\ProgramTask;
use App\Models\Company;
use App\Models\User;
use CardzApp\Api\Shared\Application\Actions;

class CollectBootstrap
{
    public function getPolicies()
    {
        $isCompanyPrincipal = fn(User $sub, Company $res) => $sub->id === $res->founder_id;
        $isProgramPrincipal = fn(User $sub, Program $res) => $sub->id === $res->company->founder_id;
        $isProgramTaskPrincipal = fn(User $sub, ProgramTask $res) => $sub->id === $res->company->founder_id;

        return array_merge([
            Actions::COLLECT_ADD_PROGRAM => $isCompanyPrincipal,
            Actions::COLLECT_GET_PROGRAMS => $isCompanyPrincipal,
            Actions::COLLECT_UPDATE_PROGRAM => $isProgramPrincipal,
            Actions::COLLECT_GET_PROGRAM => $isProgramPrincipal,
            Actions::COLLECT_UPDATE_PROGRAM_AVAILABLE => $isProgramPrincipal
        ], [
            Actions::COLLECT_ADD_PROGRAM_TASK => $isProgramPrincipal,
            Actions::COLLECT_GET_PROGRAM_TASKS => $isProgramPrincipal,
            Actions::COLLECT_UPDATE_PROGRAM_TASK => $isProgramTaskPrincipal,
            Actions::COLLECT_GET_PROGRAM_TASK => $isProgramTaskPrincipal,
            Actions::COLLECT_UPDATE_PROGRAM_TASK_AVAILABLE => $isProgramTaskPrincipal
        ]);
    }
}
