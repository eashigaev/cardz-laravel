<?php

namespace App\Models\Collect;

use App\Models\Company;
use Codderz\YokoLite\Infrastructure\Database\Model\HasManySyncableTrait;
use Codderz\YokoLite\Infrastructure\Database\Model\OptimisticLockingTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory,
        HasManySyncableTrait,
        OptimisticLockingTrait;

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

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function tasks()
    {
        return $this->hasManySyncable(Task::class);
    }

    //

    public static function ofIdOrFail(string $programId)
    {
        return static::query()->with('tasks')->findOrFail($programId);
    }

    public static function ofTaskIdOrFail(string $taskId)
    {
        return static::query()->with('program', 'program.tasks')->findOrFail($taskId);
    }
}
