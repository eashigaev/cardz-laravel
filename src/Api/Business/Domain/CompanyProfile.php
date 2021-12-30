<?php

namespace CardzApp\Api\Business\Domain;

class CompanyProfile
{
    public $title;
    public $description;
    public $about;

    public static function of(string $title, string $description, string $about)
    {
        $self = new self();
        $self->title = $title;
        $self->description = $description;
        $self->about = $about;
        return $self;
    }

    public function toArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'about' => $this->about
        ];
    }
}
