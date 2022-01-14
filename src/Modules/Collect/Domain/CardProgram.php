<?php

namespace CardzApp\Modules\Collect\Domain;

use Codderz\YokoLite\Domain\Uuid\Uuid;
use Ramsey\Collection\Collection;

class CardProgram
{
    public Uuid $companyId;
    public Uuid $programId;
    public int $target;
    public bool $active;
    public Collection $availableTasks;

    public static function of(Uuid $companyId, Uuid $programId, int $target, bool $active, Collection $availableTasks)
    {
        $self = new self();
        $self->companyId = $companyId;
        $self->programId = $programId;
        $self->target = $target;
        $self->active = $active;
        $self->availableTasks = $availableTasks;
        return $self;
    }
}
