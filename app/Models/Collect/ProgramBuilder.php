<?php

namespace App\Models\Collect;

use Illuminate\Database\Eloquent\Builder;

class ProgramBuilder extends Builder
{
    public function ofCompany(string $companyId)
    {
        return $this->where('company_id', $companyId);
    }
}
