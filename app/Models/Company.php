<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public $table = 'companies';
    public $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'description',
        'about',
    ];

    public function founder()
    {
        return $this->belongsTo(User::class, 'founder_id');
    }

    //

    public static function query(): Builder|CompanyBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query)
    {
        return new CompanyBuilder($query);
    }
}