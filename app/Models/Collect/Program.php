<?php

namespace App\Models\Collect;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    public $table = 'collect_programs';
    public $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'description',
        'reward_title',
        'reward_target'
    ];

    //

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
