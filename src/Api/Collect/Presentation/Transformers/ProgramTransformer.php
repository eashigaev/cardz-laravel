<?php

namespace CardzApp\Api\Collect\Presentation\Transformers;

use App\Models\Collect\Program;
use Illuminate\Database\Eloquent\Model;

class ProgramTransformer
{
    public function preview(Model|Program $model): array
    {
        return [
            'id' => $model->id,
            'title' => $model->title,
            'description' => $model->description,
            'available' => $model->available
        ];
    }

    public function detail(Model|Program $model): array
    {
        return $this->preview($model);
    }
}
