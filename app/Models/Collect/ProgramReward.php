<?php

namespace App\Models\Collect;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramReward extends Model
{
    use HasFactory;

    public $table = 'collect_program_rewards';
    public $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'amount'
    ];

    public function tenant()
    {
        return $this->belongsTo(Company::class, 'tenant_id');
    }
}
