<?php

namespace CardzApp\Api\Business\Transformers;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;

class CompanyTransformer
{
    public function preview(Model|Company $model): array
    {
        return [
            'id' => $model->id,
            'title' => $model->title,
            'description' => $model->description
        ];
    }

    public function detail(Model|Company $model): array
    {
        return [
            ...$this->preview($model),
            'summary' => $model->summary
        ];
    }
}
