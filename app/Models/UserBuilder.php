<?php

namespace App\Models;

use Codderz\YokoLite\Shared\Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserBuilder extends Builder
{
    public function findOrFailWhereCredentials(string $username, string $password)
    {
        $user = $this
            ->where('username', $username)
            ->firstOrFail();

        if (!Hash::check($password, $user->password)) {
            throw Exception::of('Unknown credentials');
        }

        return $user;
    }
}
