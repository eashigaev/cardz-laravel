<?php

namespace CardzApp\Api\Account\Domain;

use Illuminate\Contracts\Hashing\Hasher;

class UserCredentials
{
    public string $username;
    public string $password;

    public static function of(string $username, string $password)
    {
        $self = new self();
        $self->username = $username;
        $self->password = $password;
        return $self;
    }

    public function toArray()
    {
        return [
            'username' => $this->username,
            'password' => $this->password
        ];
    }

    public function toHashedArray(Hasher $hasher)
    {
        return self::of(
            $this->username, $hasher->make($this->password)
        )->toArray();
    }
}
