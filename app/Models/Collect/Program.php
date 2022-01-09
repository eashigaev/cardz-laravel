<?php

namespace App\Models\Collect;

use App\Models\Company;
use CardzApp\Api\Collect\Domain\ProgramProfile;
use CardzApp\Api\Collect\Domain\ProgramReward;
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

    public function setProfile(ProgramProfile $profile)
    {
        return $this->fill([
            'title' => $profile->getTitle(),
            'description' => $profile->getDescription(),
        ]);
    }

    public function setReward(ProgramReward $reward)
    {
        return $this->fill([
            'reward_title' => $reward->getTitle(),
            'reward_target' => $reward->getTarget(),
        ]);
    }

    //

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function tasks()
    {
        return $this->hasMany(ProgramTask::class);
    }
}
