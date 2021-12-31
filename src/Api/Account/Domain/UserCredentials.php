<?php

namespace CardzApp\Api\Account\Domain;

use Hash;

class UserCredentials
{
    public string $username;
    public string $password;

    public static function ofPlain(string $username, string $password)
    {
        return self::of(
            $username, Hash::make($password)
        );
    }

    //

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
}
