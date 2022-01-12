<?php

namespace CardzApp\Modules\Collect\Infrastructure\Mediators;

use App\Models\Company;
use CardzApp\Modules\Collect\Domain\CompanyAggregate;
use Codderz\YokoLite\Domain\Uuid\Uuid;

class CompanyMediator
{
    public function of(Company $company): CompanyAggregate
    {
        return CompanyAggregate::of(
            Uuid::of($company->id)
        );
    }
}
