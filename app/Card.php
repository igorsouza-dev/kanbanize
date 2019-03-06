<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function moveLeft()
    {
        $left = $this->column->leftColumn();
        $this->column_id = $left->id;
        return $this->save();
    }

    public function moveRight()
    {
        $right = $this->column->rightColumn();
        $this->column_id = $right->id;
        return $this->save();
    }

    public function column()
    {
        return $this->belongsTo(Column::class);
    }


}
