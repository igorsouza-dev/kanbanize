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
        if(count($left->cards)+1 <= $left->max_cards) {
            $status = $this->save();
            $error = '';
            if(!$status) {
                $error = 'Não foi possível salvar mudança';
            }
        } else {
            $status = false;
            $error = 'Nº máximo de cards atingido.';
        }
        return ['status'=>$status, 'error'=>$error];
    }
    public function move($column, $pos)
    {
        if($column->id != $this->column_id) {
            if(count($column->cards) >= $column->max_cards) {
                $status = false;
                $error = 'Nº máximo de cards atingido.';
            } else {
                $this->column_id = $column->id;
                $this->column_position = $pos;
                $status = $this->save();
                $error = '';
            }
        } else {
            $this->column_position = $pos;
            $status = $this->save();
            $error = '';
        }

        $i=0;
        $cards = Column::find($column->id)->cards;
        foreach($cards as $card) {
            if($card->id == $this->id) {
                continue;
            }
            if($i == $pos) {
                $i++;
            }
            $card->column_position = $i;
            $card->save();
            $i++;
        }
        return ['status'=>$status, 'error'=>$error];
    }
    public function moveRight()
    {
        $right = $this->column->rightColumn();
        $this->column_id = $right->id;
        if(count($right->cards)+1 <= $right->max_cards) {
            $status = $this->save();
            $error = '';
            if(!$status) {
                $error = 'Não foi possível salvar mudança';
            }
        } else {
            $status = false;
            $error = 'Nº máximo de cards atingido.';
        }
        return ['status'=>$status, 'error'=>$error];
    }

    public function column()
    {
        return $this->belongsTo(Column::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
