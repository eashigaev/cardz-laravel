<?php

namespace App\Models\Collect;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

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
        return $this->hasMany(Achievement::class);
    }
}
