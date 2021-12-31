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
            $username,
            self::hashPassword($password)
        );
    }

    public function checkPassword(string $password)
    {
        return Hash::check($password, $this->password);
    }

    //

    public static function hashPassword(string $password)
    {
        return Hash::make($password);
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
