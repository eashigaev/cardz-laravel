<?php

namespace Codderz\YokoLite\Presentation;

use App\Models\User;
use Auth;

trait AuthUserTrait
{
    public function user()
    {
        return User::query()->findOrFail(Auth::id());
    }
}
