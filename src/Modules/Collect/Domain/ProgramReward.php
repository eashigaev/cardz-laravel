<?php

namespace CardzApp\Modules\Collect\Domain;

class ProgramReward
{
    private string $title;
    private int $target;

    public static function of(string $title, int $target)
    {
        $self = new self();
        $self->title = $title;
        $self->target = $target;
        return $self;
    }

    //

    public function getTitle()
    {
        return $this->title;
    }

    public function getTarget()
    {
        return $this->target;
    }
}
