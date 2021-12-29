<?php

namespace App\Models\Collect;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
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
        'description'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function tasks()
    {
        return $this->hasMany(ProgramTask::class);
    }

    public function rewards()
    {
        return $this->hasMany(ProgramReward::class);
    }

    //

    public static function query(): Builder|ProgramBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query)
    {
        return new ProgramBuilder($query);
    }
}
