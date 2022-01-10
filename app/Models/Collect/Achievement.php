<?php

namespace App\Models\Collect;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    public $table = 'collect_achievements';
    public $keyType = 'string';
    public $incrementing = false;

    //

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
