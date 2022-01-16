<?php

namespace CardzApp\Api\Collect\Transformers;

use App\Models\Collect\Achievement;
use Illuminate\Database\Eloquent\Model;

class AchievementTransformer
{
    public function transform(Model|Achievement $model): array
    {
        return [
            'id' => $model->id,
            'company_id' => $model->company_id,
            'program_id' => $model->program_id,
            'title' => $model->task->title,
            'created_at' => $model->created_at->toString()
        ];
    }
}
