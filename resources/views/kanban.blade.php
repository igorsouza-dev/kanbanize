@extends('layouts.app')

@section('title', 'Kanban')
@section('content')
    <h1>Board "{{ $board->name }}"</h1>
    <kanban :board="{{$board->id}}"></kanban>

@endsection
