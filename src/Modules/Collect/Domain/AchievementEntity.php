<?php

namespace CardzApp\Modules\Collect\Domain;

use Codderz\YokoLite\Domain\Uuid\Uuid;

class AchievementEntity
{
    public Uuid $id;
    public Uuid $taskId;
    public bool $removed;

    public static function add(Uuid $id, Uuid $taskId)
    {
        return self::of($id, $taskId);
    }

    public function remove()
    {
        $this->removed = true;
    }

    //

    public static function of(Uuid $id, Uuid $taskId)
    {
        $self = new self();
        $self->id = $id;
        $self->taskId = $taskId;
        $self->removed = false;
        return $self;
    }
}
