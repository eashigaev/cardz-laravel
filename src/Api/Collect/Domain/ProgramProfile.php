<?php

namespace CardzApp\Api\Collect\Domain;

class ProgramProfile
{
    public string $title;
    public string $description;

    public static function of(string $title, string $description)
    {
        $self = new self();
        $self->title = $title;
        $self->description = $description;
        return $self;
    }

    public function toArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description
        ];
    }
}
