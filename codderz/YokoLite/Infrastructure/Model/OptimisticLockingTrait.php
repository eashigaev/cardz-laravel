<?php

namespace Codderz\YokoLite\Infrastructure\Model;

use Illuminate\Database\Eloquent\Builder;

trait OptimisticLockingTrait
{
    public function performInsert(Builder $query)
    {
        $this->meta_version = 1;

        return parent::performInsert($query);
    }

    public function performUpdate(Builder $query)
    {
        $query->where('meta_version', $this->meta_version);

        $this->meta_version += 1;

        return parent::performUpdate($query);
    }
}
