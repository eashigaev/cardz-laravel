<?php

namespace App\Models;

use Codderz\YokoLite\Shared\Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserBuilder extends Builder
{
    public function firstOrFailWhereCredentials(string $username, string $password)
    {
        $self = $this
            ->where('username', $username)
            ->firstOrFail();

        if (!Hash::check($password, $self->password)) {
            throw Exception::of('Unknown credentials');
        }

        return $self;
    }
}
