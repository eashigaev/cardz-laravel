<?php

namespace CardzApp\Modules\Collect\Application;

use App\Models\Collect\Card;
use App\Models\Collect\Program;
use App\Models\Collect\Task;
use App\Models\Company;
use App\Models\User;
use CardzApp\Modules\Shared\Application\Actions;

class CollectPolicy
{
    public function getRules()
    {
        $isCompanyPrincipal = fn(User $sub, Company $res) => $sub->id === $res->founder_id;
        $isProgramPrincipal = fn(User $sub, Program $res) => $sub->id === $res->company->founder_id;
        $isProgramTaskPrincipal = fn(User $sub, Task $res) => $sub->id === $res->company->founder_id;
        $isCardPrincipal = fn(User $sub, Card $res) => $sub->id === $res->company->founder_id;
        $isCardHolder = fn(User $sub, Card $res) => $sub->id === $res->holder_id;

        return array_merge([
            Actions::COLLECT_ADD_PROGRAM => $isCompanyPrincipal,
            Actions::COLLECT_GET_PROGRAMS => $isCompanyPrincipal,
            Actions::COLLECT_UPDATE_PROGRAM => $isProgramPrincipal,
            Actions::COLLECT_GET_PROGRAM => $isProgramPrincipal,
            Actions::COLLECT_UPDATE_PROGRAM_ACTIVE => $isProgramPrincipal
        ], [
            Actions::COLLECT_ADD_TASK => $isProgramPrincipal,
            Actions::COLLECT_GET_TASKS => $isProgramPrincipal,
            Actions::COLLECT_UPDATE_TASK => $isProgramTaskPrincipal,
            Actions::COLLECT_GET_TASK => $isProgramTaskPrincipal,
            Actions::COLLECT_UPDATE_TASK_ACTIVE => $isProgramTaskPrincipal
        ], [
            Actions::COLLECT_ISSUE_CARD => $isProgramPrincipal,
            Actions::COLLECT_UPDATE_CARD => $isCardPrincipal,
            Actions::COLLECT_REJECT_CARD => $isCardPrincipal,
            Actions::COLLECT_CANCEL_CARD => $isCardHolder,
            Actions::COLLECT_REWARD_CARD => $isCardPrincipal,
        ]);
    }
}
