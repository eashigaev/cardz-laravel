<?php

namespace App\Models\Collect;

use App\Models\Company;
use App\Models\User;
use Codderz\YokoLite\Infrastructure\Database\Model\HasManySyncableTrait;
use Codderz\YokoLite\Infrastructure\Database\Model\OptimisticLockingTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory,
        HasManySyncableTrait,
        OptimisticLockingTrait;

    public $table = 'collect_cards';
    public $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'comment'
    ];

    //

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function holder()
    {
        return $this->belongsTo(User::class, 'holder_id');
    }

    public function achievements()
    {
        return $this->hasManySyncable(Achievement::class);
    }
}
