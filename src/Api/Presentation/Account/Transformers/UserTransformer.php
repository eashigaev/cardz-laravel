<?php

namespace CardzApp\Api\Presentation\Account\Transformers;

use App\Models\User;

class UserTransformer
{
    public function public(User $model): array
    {
        return [
            'id' => $model->id,
            'username' => $model->username,
            'createdAt' => $model->created_at
        ];
    }

    public function private(User $model): array
    {
        return [
            ...$this->public($model),
            'email' => $model->email,
        ];
    }
}
