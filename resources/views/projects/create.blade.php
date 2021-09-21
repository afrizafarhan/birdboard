@extends('layouts.app')

@section('content')    
    <div class="container">
        <h1>Create Project</h1>

        <form action="/projects" method="post">
            @csrf
            <div class="form-group">
                <label for="">Title</label>
                <input type="text" name="title" id="title" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Descriptions</label>
                <textarea name="descriptions" id="descriptions" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
        </form>
    </div>
@endsection