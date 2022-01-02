<?php

namespace CardzApp\Api\Account\Domain;

use Illuminate\Support\Facades\Hash;

class UserCredentials
{
    public string $username;
    public string $password;
    public bool $hashed = false;

    public static function of(string $username, string $password, bool $hashed = false)
    {
        $self = new self();
        $self->username = $username;
        $self->password = $password;
        $self->hashed = $hashed;
        return $self;
    }

    public function hash()
    {
        return self::of($this->username, Hash::make($this->password), true);
    }

    public function toArray()
    {
        return [
            'username' => $this->username,
            'password' => $this->password
        ];
    }
}
