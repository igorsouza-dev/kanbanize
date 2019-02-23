@extends('layouts.app')

@section('content')
    <h1>New Project</h1>
    <form method="post" action="/boards">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}" id="name" name="name" aria-describedby="name" placeholder="Enter the name" value="{{ old('name') }}">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>

        @include('layouts.errors')
    </form>
@endsection
