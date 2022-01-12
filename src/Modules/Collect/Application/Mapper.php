<?php

namespace CardzApp\Modules\Collect\Application;

use App\Models\Company;
use CardzApp\Modules\Collect\Domain\CompanyAggregate;
use Codderz\YokoLite\Domain\Uuid\Uuid;

class Mapper
{
    public function companyAggregate(Company $model): CompanyAggregate
    {
        $aggregate = new CompanyAggregate;
        $aggregate->id = Uuid::of($model->id);
        return $aggregate;
    }
}
