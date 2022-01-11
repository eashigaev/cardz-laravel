<?php

namespace App\Models\Collect;

use App\Models\Company;
use CardzApp\Modules\Collect\Domain\TaskFeature;
use CardzApp\Modules\Collect\Domain\TaskProfile;
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

    //

    public function setProfile(TaskProfile $profile)
    {
        return $this->fill([
            'title' => $profile->getTitle(),
            'description' => $profile->getDescription(),
        ]);
    }

    public function setFeature(TaskFeature $feature)
    {
        return $this->fill([
            'repeatable' => $feature->isRepeatable()
        ]);
    }
}
