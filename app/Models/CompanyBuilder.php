<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class CompanyBuilder extends Builder
{
    public function ofFounder(string $founderId)
    {
        return $this->where('founder_id', $founderId);
    }
}
