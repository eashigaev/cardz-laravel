<?php

namespace App\Models;

use Codderz\YokoLite\Shared\Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $table = 'users';
    public $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Attributes

    public function setPasswordAttribute(string $password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    // Relations

    public function companies()
    {
        return $this->hasMany(Company::class, 'founder_id');
    }

    // Queries

    public static function findByCredentialsOrFail(string $username, string $password)
    {
        $user = User::query()
            ->where('username', $username)
            ->firstOrFail();

        if (!Hash::check($password, $user->password)) {
            throw Exception::of('Unknown credentials');
        }

        return $user;
    }

    //

    public static function query(): Builder|UserBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query)
    {
        return new UserBuilder($query);
    }
}
