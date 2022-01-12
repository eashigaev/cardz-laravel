<?php

namespace App\Models\Collect;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public $table = 'collect_tasks';
    public $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'description',
        'repeatable'
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
}
