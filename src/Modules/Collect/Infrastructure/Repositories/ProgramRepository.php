<?php

namespace CardzApp\Modules\Collect\Infrastructure\Repositories;

use App\Models\Collect\Program;
use CardzApp\Modules\Collect\Domain\ProgramAggregate;
use CardzApp\Modules\Collect\Domain\ProgramProfile;
use CardzApp\Modules\Collect\Domain\ProgramReward;
use Codderz\YokoLite\Domain\Uuid\Uuid;

class ProgramRepository
{
    public function of(Program $program): ProgramAggregate
    {
        return ProgramAggregate::of(
            Uuid::of($program->id),
            Uuid::of($program->company_id),
            ProgramProfile::of($program->title, $program->description),
            ProgramReward::of($program->reward_title, $program->reward_target),
            $program->active
        )
            ->withMetaVersion($program->meta_version);
    }

    public function create(ProgramAggregate $aggregate)
    {
        Program::query()->insert([
            'id' => $aggregate->id->getValue(),
            'company_id' => $aggregate->companyId->getValue(),
            'title' => $aggregate->profile->getTitle(),
            'description' => $aggregate->profile->getDescription(),
            'reward_title' => $aggregate->reward->getTitle(),
            'reward_target' => $aggregate->reward->getTarget(),
            'active' => $aggregate->active,
            'meta_version' => $aggregate->nextMetaVersion()
        ]);
    }

    public function update(ProgramAggregate $aggregate)
    {
        Program::query()->where([
            'id' => $aggregate->id->getValue(),
            'meta_version' => $aggregate->getMetaVersion()
        ])->update([
            'title' => $aggregate->profile->getTitle(),
            'description' => $aggregate->profile->getDescription(),
            'reward_title' => $aggregate->reward->getTitle(),
            'reward_target' => $aggregate->reward->getTarget(),
            'active' => $aggregate->active,
            'meta_version' => $aggregate->nextMetaVersion()
        ]);
    }
}
