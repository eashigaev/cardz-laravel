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
        'description'
    ];

    public function tenant()
    {
        return $this->belongsTo(Company::class, 'tenant_id');
    }

    public function tasks()
    {
        return $this->hasMany(ProgramTask::class, 'program_id');
    }

    public function rewards()
    {
        return $this->hasMany(ProgramReward::class, 'program_id');
    }
}
