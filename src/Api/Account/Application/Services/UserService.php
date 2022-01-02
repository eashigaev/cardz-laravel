<?php

namespace CardzApp\Api\Account\Application\Services;

use App\Models\User;
use CardzApp\Api\Account\Domain\UserCredentials;
use CardzApp\Api\Account\Domain\UserProfile;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Codderz\YokoLite\Shared\Exception;
use Illuminate\Contracts\Hashing\Hasher;

class UserService
{
    public function __construct(
        private UuidGenerator $uuidGenerator,
        private Hasher        $hasher
    )
    {
    }

    public function registerUser(UserCredentials $credentials, UserProfile $profile)
    {
        $user = User::query()->make([
            ...$credentials->toHashedArray($this->hasher),
            ...$profile->toArray()
        ]);
        $user->id = $this->uuidGenerator->getNextValue();
        $user->save();

        return $user->id;
    }

    public function updateUser(string $id, UserCredentials $credentials)
    {
        $user = User::query()->findOrFail($id);

        return $user
            ->fill($credentials->toHashedArray($this->hasher))
            ->save();
    }

    //

    public function getUser(string $id)
    {
        return User::query()->findOrFail($id);
    }

    public function getUserByCredentials(UserCredentials $credentials)
    {
        $user = User::query()
            ->where('username', $credentials->username)
            ->firstOrFail();

        if (!$this->hasher->check($credentials->password, $user->password)) {
            throw Exception::of('Unknown credentials');
        }

        return $user;
    }
}
