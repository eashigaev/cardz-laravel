<?php

namespace CardzApp\Modules\Collect\Domain;

use Codderz\YokoLite\Domain\Uuid\Uuid;
use Codderz\YokoLite\Shared\Exception;
use Illuminate\Support\Collection;

class ProgramAggregate
{
    public Uuid $id;
    public Uuid $companyId;
    public ProgramProfile $profile;
    public ProgramReward $reward;
    public bool $active;

    public Collection $tasks;

    public static function add(Uuid $id, Uuid $companyId, ProgramProfile $profile, ProgramReward $reward)
    {
        return self::of($id, $companyId, $profile, $reward, false, Collection::make());
    }

    public function update(ProgramProfile $profile, ProgramReward $reward)
    {
        $this->profile = $profile;
        $this->reward = $reward;
    }

    public function updateActive(bool $value)
    {
        if ($this->active === $value) return;

        $this->active = $value;
    }

    //

    public function findTask(callable $criteria): TaskEntity|null
    {
        return $this->tasks->first($criteria);
    }

    public function addTask(Uuid $id, TaskProfile $profile, TaskFeature $feature)
    {
        $task = TaskEntity::add($id, $profile, $feature);

        $this->tasks = $this->tasks->add($task);

        return $task->id;
    }

    public function updateTask(Uuid $taskId, TaskProfile $profile, TaskFeature $feature)
    {
        $task = $this->findTask(fn(TaskEntity $i) => $i->id->isEquals($taskId));

        $task->update($profile, $feature);
    }

    public function updateTaskActive(Uuid $taskId, bool $value)
    {
        $task = $this->findTask(
            fn(TaskEntity $e) => $e->id->isEquals($taskId)
        );

        if (!$task) {
            throw Exception::of(Messages::NOT_FOUND);
        }

        $task->updateActive($value);
    }

    //

    public static function of(
        Uuid $id, Uuid $companyId, ProgramProfile $profile, ProgramReward $reward, bool $active, Collection $tasks
    )
    {
        $self = new self();
        $self->id = $id;
        $self->companyId = $companyId;
        $self->profile = $profile;
        $self->reward = $reward;
        $self->active = $active;
        $self->tasks = $tasks;
        return $self;
    }
}
