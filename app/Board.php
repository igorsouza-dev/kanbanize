<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function columns()
    {
        return $this->hasMany(Column::class);
    }

    public function addColumn($attributes)
    {
        $this->columns()->create($attributes);
    }
}
