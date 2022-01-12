<?php

namespace App\Models\Collect;

use App\Models\Company;
use CardzApp\Modules\Collect\Domain\ProgramAggregate;
use CardzApp\Modules\Collect\Domain\ProgramProfile;
use CardzApp\Modules\Collect\Domain\ProgramReward;
use Codderz\YokoLite\Domain\Uuid\Uuid;
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
        return $this->hasMany(Task::class);
    }

    //

    public function aggregate(callable $callable): self
    {
        $aggregate = $this->asAggregate();
        $callable($aggregate);
        $this->applyAggregate($aggregate);
        return $this;
    }

    public function asAggregate(): ProgramAggregate
    {
        return ProgramAggregate::of(
            Uuid::of($this->id),
            Uuid::of($this->company_id),
            ProgramProfile::of($this->title, $this->description),
            ProgramReward::of($this->reward_title, $this->reward_target),
            $this->active
        );
    }

    public function applyAggregate(ProgramAggregate $aggregate)
    {
        $this->id = $aggregate->id->getValue();
        $this->company_id = $aggregate->companyId->getValue();
        $this->title = $aggregate->profile->getTitle();
        $this->description = $aggregate->profile->getDescription();
        $this->reward_title = $aggregate->reward->getTitle();
        $this->reward_target = $aggregate->reward->getTarget();
        $this->active = $aggregate->active;
        return $this;
    }
}
