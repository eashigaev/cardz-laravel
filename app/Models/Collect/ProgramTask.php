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
        'repeatable'
    ];

    public function tenant()
    {
        return $this->belongsTo(Company::class, 'tenant_id');
    }
}
