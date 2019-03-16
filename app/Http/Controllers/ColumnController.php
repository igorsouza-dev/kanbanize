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
        return Column::create($request->validate([
            'board_id' => ['required'],
            'name' => ['required', 'min:3', 'max:255'],
            'board_position' => ['required', 'integer'],
            'max_cards' => ['required', 'integer'],
            'min_cards' => ['required', 'integer'],
        ]));

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
