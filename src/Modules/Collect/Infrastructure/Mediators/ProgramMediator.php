<?php

namespace CardzApp\Modules\Collect\Infrastructure\Mediators;

use App\Models\Collect\Program;
use CardzApp\Modules\Collect\Domain\ProgramAggregate;
use CardzApp\Modules\Collect\Domain\ProgramProfile;
use CardzApp\Modules\Collect\Domain\ProgramReward;
use Codderz\YokoLite\Domain\Uuid\Uuid;

class ProgramMediator
{
    protected array $map = [];

    public function of(Program $program): ProgramAggregate
    {
        return ProgramAggregate::of(
            Uuid::of($program->id),
            Uuid::of($program->company_id),
            ProgramProfile::of($program->title, $program->description),
            ProgramReward::of($program->reward_title, $program->reward_target),
            $program->active
        );
    }

    public function save(ProgramAggregate $aggregate)
    {
        $program = Program::firstOrNew();
        $program->id = $aggregate->id->getValue();
        $program->company_id = $aggregate->companyId->getValue();
        $program->title = $aggregate->profile->getTitle();
        $program->description = $aggregate->profile->getDescription();
        $program->reward_title = $aggregate->reward->getTitle();
        $program->reward_target = $aggregate->reward->getTarget();
        $program->active = $aggregate->active;
        $program->save();
        return $program;
    }
}
