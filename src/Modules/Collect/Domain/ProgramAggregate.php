<?php

namespace CardzApp\Modules\Collect\Domain;

use Codderz\YokoLite\Domain\OptimisticLockingTrait;
use Codderz\YokoLite\Domain\Uuid\Uuid;

class ProgramAggregate
{
    use OptimisticLockingTrait;

    public Uuid $id;
    public Uuid $companyId;
    public ProgramProfile $profile;
    public ProgramReward $reward;
    public bool $active;

    public static function add(Uuid $id, Uuid $companyId, ProgramProfile $profile, ProgramReward $reward)
    {
        return self::of($id, $companyId, $profile, $reward, false);
    }

    public function update(ProgramProfile $profile, ProgramReward $reward)
    {
        $this->profile = $profile;
        $this->reward = $reward;
    }

    public function updateActive(bool $value)
    {
        if ($this->active === $value) return;

        $this->active = $value;
    }

    //

    public static function of(
        Uuid $id, Uuid $companyId, ProgramProfile $profile, ProgramReward $reward, bool $active
    )
    {
        $self = new self();
        $self->id = $id;
        $self->companyId = $companyId;
        $self->profile = $profile;
        $self->reward = $reward;
        $self->active = $active;
        return $self;
    }
}
