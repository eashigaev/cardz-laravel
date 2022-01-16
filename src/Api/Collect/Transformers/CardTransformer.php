<?php

namespace CardzApp\Api\Collect\Transformers;

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
            'comment' => $model->comment,
            'holder_username' => $model->holder->username,
        ];
    }
}
