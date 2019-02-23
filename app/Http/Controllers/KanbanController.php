<?php

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;

class KanbanController extends Controller
{
    public function show(Board $board)
    {
        return view('kanban', ['board'=>$board]);
    }
}
