<?php

namespace Codderz\YokoLite\Infrastructure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait PersistenceTrait
{
    public function execute(callable $callback)
    {
        Model::unguard();
        DB::transaction($callback);
        Model::reguard();
    }
}
