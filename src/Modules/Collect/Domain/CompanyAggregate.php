<?php

namespace CardzApp\Modules\Collect\Domain;

use Codderz\YokoLite\Domain\Uuid\Uuid;

class CompanyAggregate
{
    public Uuid $id;

    public static function of(Uuid $id)
    {
        $self = new self();
        $self->id = $id;
        return $self;
    }
}
