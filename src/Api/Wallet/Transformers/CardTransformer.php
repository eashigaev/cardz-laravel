<?php

namespace CardzApp\Api\Wallet\Transformers;

use App\Models\Collect\Achievement;
use App\Models\Collect\Card;
use Illuminate\Database\Eloquent\Model;

class CardTransformer
{
    public function preview(Model|Card $model): array
    {
        return [
            'id' => $model->id,
            'company_id' => $model->company_id,
            'company_title' => $model->company->title,
            'program_id' => $model->program_id,
            'program_title' => $model->program->title,
            'holder_id' => $model->holder_id,
            'balance' => $model->balance,
            'status' => $model->status
        ];
    }

    public function detail(Model|Card $model): array
    {
        return [
            ...$this->preview($model),
            'achievements' => $model->achievements->map(fn(Achievement $item) => [
                'id' => $item->id,
                'task_title' => $item->task->title,
                'created_at' => $item->created_at->toString(),
            ])
        ];
    }
}
