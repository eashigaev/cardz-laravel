<?php

namespace CardzApp\Api\Business\Domain;

class CompanyProfile
{
    public string $title;
    public string $description;
    public string $summary;

    public static function of(string $title, string $description, string $summary)
    {
        $self = new self();
        $self->title = $title;
        $self->description = $description;
        $self->summary = $summary;
        return $self;
    }

    public function toArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'summary' => $this->summary
        ];
    }
}
