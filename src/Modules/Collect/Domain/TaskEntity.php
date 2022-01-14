<?php

namespace CardzApp\Modules\Collect\Domain;

use Codderz\YokoLite\Domain\Uuid\Uuid;

class TaskEntity
{
    public Uuid $id;
    public TaskProfile $profile;
    public TaskFeature $feature;
    public bool $active;

    public static function add(Uuid $id, TaskProfile $profile, TaskFeature $feature)
    {
        $self = new self();
        $self->id = $id;
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

    public static function of(Uuid $id, TaskProfile $profile, TaskFeature $feature, bool $active)
    {
        $self = new self();
        $self->id = $id;
        $self->profile = $profile;
        $self->feature = $feature;
        $self->active = $active;
        return $self;
    }
}
