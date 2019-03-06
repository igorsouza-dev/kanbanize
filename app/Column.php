<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Column extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function cards()
    {
        return $this->hasMany(Card::class)->orderBy('column_position');
    }

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function leftColumn()
    {
        $columns = $this->board->columns;
        $leftColumn = null;
        foreach($columns as $column) {
            if(is_null($leftColumn)) {
                $leftColumn = $column;
            }
            if($column->board_position != $this->board_position) {
                $leftColumn = $column;
            }
            if($column->id == $this->id) {
                break;
            }
        }
        return $leftColumn;
    }
    public function rightColumn()
    {
        $columns = $this->board->columns;
        $rightColumn = null;
        $found = false;
        foreach($columns as $column) {
            if($found) {
                $rightColumn = $column;
                break;
            }
            if($column->id == $this->id) {
                $rightColumn = $column;
                $found = true;
            }
        }
        return $rightColumn;
    }
}
