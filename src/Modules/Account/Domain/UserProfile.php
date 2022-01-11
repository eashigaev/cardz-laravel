<?php

namespace CardzApp\Modules\Account\Domain;

class UserProfile
{
    public string $email;

    public static function of(string $email)
    {
        $self = new self();
        $self->email = $email;
        return $self;
    }

    public function toArray()
    {
        return [
            'email' => $this->email
        ];
    }
}
