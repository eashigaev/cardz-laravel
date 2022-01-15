<?php

namespace Codderz\YokoLite\Infrastructure\Model;

use Codderz\YokoLite\Infrastructure\Model\Relations\HasManySyncable;

trait HasManySyncableTrait
{
    public function hasManySyncable($related, $foreignKey = null, $localKey = null)
    {
        $instance = $this->newRelatedInstance($related);

        $foreignKey = $foreignKey ?: $this->getForeignKey();

        $localKey = $localKey ?: $this->getKeyName();

        return new HasManySyncable(
            $instance->newQuery(), $this, $instance->getTable() . '.' . $foreignKey, $localKey
        );
    }
}
