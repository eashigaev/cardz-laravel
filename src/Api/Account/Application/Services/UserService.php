<?php

namespace CardzApp\Api\Account\Application\Services;

use App\Models\User;
use CardzApp\Api\Account\Domain\UserCredentials;
use CardzApp\Api\Account\Domain\UserProfile;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;

class UserService
{
    public function __construct(
        private UuidGenerator $uuidGenerator
    )
    {
    }

    public function registerUser(UserCredentials $credentials, UserProfile $profile)
    {
        $user = User::query()->make(
            collect($credentials->toArray())
                ->merge($profile->toArray())
                ->toArray()
        );
        $user->id = $this->uuidGenerator->getNextValue();
        $user->save();

        return $user->id;
    }

    public function updateOwnUser(string $id, UserCredentials $credentials)
    {
        $user = User::query()->findOrFail($id);
        $user->fill($credentials->toArray());
        $user->save();
    }

    //

    public function getOwnerUser(string $id)
    {
        return User::query()->findOrFail($id);
    }
}
