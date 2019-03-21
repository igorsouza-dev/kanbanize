<?php

namespace App\Http\Controllers;

use App\Board;
use App\Column;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'board_id' => ['required'],
            'name' => ['required', 'min:3', 'max:255'],
            'max_cards' => ['required', 'integer'],
        ]);
        $board = Board::find($validated['board_id']);
        $validated['board_position'] = $board->lastBoardPosition();
        return Column::create($validated);
    }
    public function moveColumn(Column $column)
    {
        $pos = request('pos');
        $column->board_position = $pos;
        $column->save();

        $i=0;
        $columns = $column->board->columns;

        foreach($columns as $col) {
            if($col->id == $column->id) {
                continue;
            }
            if($i == $pos) {
                $i++;
            }
            $col->board_position = $i;
            $col->save();
            $i++;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $column = Column::find($id);
        $column->update($request->all());
        return $column;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Column $column
     * @return void
     * @throws \Exception
     */
    public function destroy(Column $column)
    {
        $column->delete();
    }
}
