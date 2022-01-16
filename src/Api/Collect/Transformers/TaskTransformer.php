<?php

namespace CardzApp\Api\Collect\Transformers;

use App\Models\Collect\Task;
use Illuminate\Database\Eloquent\Model;

class TaskTransformer
{
    public function preview(Model|Task $model): array
    {
        return [
            'id' => $model->id,
            'company_id' => $model->company_id,
            'program_id' => $model->program_id,
            'title' => $model->title,
            'description' => $model->description,
            'repeatable' => (bool)$model->repeatable,
            'active' => (bool)$model->active
        ];
    }

    public function detail(Model|Task $model): array
    {
        return $this->preview($model);
    }
}
