@extends('layouts.app')

@section('title', 'Projects')
@section('content')
    <h1>Boards</h1>
    <div class="row">
        <div class="btn-group" role="group" aria-label="New board">
            <a class="btn btn-primary" href="{{ url('/boards/create') }}" role="button">New board</a>
        </div>
    </div>
    <div class="row">
        <table class="table table-striped table-hover">
            <thead>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col"></th>
            </thead>
            <tbody>
            @foreach($boards as $board)
                <tr>
                    <th scope="row">{{ $board->id }}</th>
                    <td>{{ $board->name }} </td>
                    <td>
                        <a class="btn btn-primary" href="{{ url("/boards/".$board->id) }}">Show</a>
                        <a class="btn btn-warning" href="{{ url("/boards/".$board->id."/kanban") }}">Kanban</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
