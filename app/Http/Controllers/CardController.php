<?php

namespace App\Http\Controllers;

use App\Card;
use App\Column;
use Illuminate\Http\Request;

class CardController extends Controller
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
        $data = request()->all();
        $column = Column::find($data['column_id']);
        if($column) {
            $data['column_position'] = $column->lastPosition();
        }
        return Card::create($data);
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
        $card = Card::find($id);
        $card->update($request->all());
        return $card;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Card $card
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Card $card)
    {
        $card->delete();
    }
    public function moveLeft(Card $card)
    {
        return response($card->moveLeft());
    }

    public function moveRight(Card $card)
    {
        return response($card->moveRight());
    }
    public function moveCard(Card $card)
    {
        $column = Column::find(request('columnId'));
        $pos = request('pos');
        return response($card->move($column, $pos));
    }
}
