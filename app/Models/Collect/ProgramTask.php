<?php

namespace App\Models\Collect;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramTask extends Model
{
    use HasFactory;

    public $table = 'collect_program_tasks';
    public $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'description'
    ];

    //

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    //

    public function scopeOfProgram($query, string $programId)
    {
        return $this->where('program_id', $programId);
    }
}
