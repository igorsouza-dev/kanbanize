@extends('layouts.app')

@section('title', 'Boards')

@section('content')
<h1>Board "{{ $board->name }}" </h1>
<a class="btn btn-primary" href="{{ url("/board/".$board->id."/edit") }}">Edit</a>
@if($board->columns->count())
    <h2>Columns</h2>
    <ul class="list-group">
        @foreach($board->columns as $column)
            <li class="list-group-item">
                <div class="input-group">
                    <form method="POST" action="/columns/{{ $column->id }}">
                        @method('PATCH')
                        @csrf
                        <label class="form-check-label" >
                                {{ $column->name }}
                        </label>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
@endif
<div class="card">
    <div class="card-header">
        <h5 class="card-title">New Column</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/boards/{{ $board->id }}/columns">
            @csrf
            <div class="form-group">
                <input type="hidden" name="board_id" value="{{ $board->id }}">

                <label for="name">
                    Name
                </label>
                <input class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}"
                       type="text" name="name"
                       required
                       placeholder="Add the name"
                       value="{{ old('name') }}">


            </div>
            <div class="form-group">
                <label for="board_position">
                    Board Position
                </label>
                <input class="form-control {{ $errors->has('board_position') ? 'border-danger' : '' }}"
                       type="text"
                       name="board_position"
                       placeholder="The position of the column on the board"
                       required value="{{ old('board_position') }}">

            </div>
            <div class="form-group">
                <label for="max_cards">
                    Max cards
                </label>
                <input class="form-control {{ $errors->has('max_cards') ? 'border-danger' : '' }}"
                       type="text"
                       name="max_cards"
                       placeholder="The maximum amount of cards in one column"
                       required value="{{ old('max_cards') }}">

            </div>
            <div class="form-group">
                <label for="min_cards">
                    Min cards
                </label>
                <input class="form-control {{ $errors->has('min_cards') ? 'border-danger' : '' }}"
                       type="text"
                       name="min_cards"
                       placeholder="The minimum amount of cards in one column"
                       required value="{{ old('min_cards') }}">

            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary"> Submit</button>
            </div>
            @include('layouts.errors')

        </form>
    </div>

</div>
@endsection

