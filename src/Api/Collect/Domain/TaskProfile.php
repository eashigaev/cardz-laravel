<?php

namespace CardzApp\Api\Collect\Domain;

class TaskProfile
{
    private string $title;
    private string $description;

    public static function of(string $title, string $description)
    {
        $self = new self();
        $self->title = $title;
        $self->description = $description;
        return $self;
    }

    //

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }
}
