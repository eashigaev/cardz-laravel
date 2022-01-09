<?php

namespace CardzApp\Api\Collect\Presentation\Transformers;

use App\Models\Collect\ProgramTask;
use Illuminate\Database\Eloquent\Model;

class ProgramTaskTransformer
{
    public function preview(Model|ProgramTask $model): array
    {
        return [
            'id' => $model->id,
            'company_id' => $model->company_id,
            'program_id' => $model->program_id,
            'title' => $model->title,
            'description' => $model->description,
            'active' => $model->active
        ];
    }

    public function detail(Model|ProgramTask $model): array
    {
        return $this->preview($model);
    }
}
