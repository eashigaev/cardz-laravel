<?php

namespace CardzApp\Modules\Collect\Domain;

use Codderz\YokoLite\Domain\OptimisticLockingTrait;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Illuminate\Support\Collection;

class TaskAggregate
{
    use OptimisticLockingTrait;

    public Uuid $id;
    public Uuid $companyId;
    public Uuid $programId;
    public TaskProfile $profile;
    public TaskFeature $feature;
    public bool $active;

    public static function add(Uuid $id, ProgramAggregate $program, TaskProfile $profile, TaskFeature $feature)
    {
        $self = new self();
        $self->id = $id;
        $self->companyId = $program->companyId;
        $self->programId = $program->id;
        $self->profile = $profile;
        $self->feature = $feature;
        $self->active = false;
        return $self;
    }

    public function update(TaskProfile $profile, TaskFeature $feature)
    {
        $this->profile = $profile;
        $this->feature = $feature;
    }

    public function updateActive(bool $value)
    {
        if ($this->active === $value) return;

        $this->active = $value;
    }

    //

    public function isAlreadyAchieved(Collection $achievedTaskIds)
    {
        return !$this->feature->isRepeatable() && $achievedTaskIds->contains($this->id->getValue());
    }

    //

    public static function of(
        Uuid $id, Uuid $companyId, Uuid $programId, TaskProfile $profile, TaskFeature $feature, bool $active
    )
    {
        $self = new self();
        $self->id = $id;
        $self->companyId = $companyId;
        $self->programId = $programId;
        $self->profile = $profile;
        $self->feature = $feature;
        $self->active = $active;
        return $self;
    }
}
