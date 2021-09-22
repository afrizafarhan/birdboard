@extends('layouts.app')

@section('content') 
    <header class="flex items-center mb-3 py-4">
        <p class="mr-auto text-gray-600 lg:text-lg"><a href="/projects">My Projects</a> / {{ $project->title }}</p>
        <a href="{{ $project->path().'/edit' }}" class="button">Edit Project</a>
    </header>

    
    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-gray-600 font-normal text-lg mb-3">Tasks</h2>
                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">
                            <form action="{{ $project->path() . '/tasks/' . $task->id }}" method="POST">
                                @method('PATCH')
                                @csrf
                                <div class="flex">
                                    <input value="{{ $task->body }}" type="text" name="body" class="w-full {{ $task->completed ? 'text-gray-400' : '' }}" id="">
                                    <input type="checkbox" name="completed" onchange="this.form.submit()" {{$task->completed ? 'checked' : ''}}>
                                </div>
                            </form>
                        </div>
                    @endforeach
                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="POST">
                            @csrf
                            <input placeholder="Add new task.." type="text" name="body" class="w-full" id="">
                        </form>
                    </div>
                </div>
                <div class="">
                    <h2 class="text-gray-600 font-normal text-lg mb-3">General Notes</h2>
                    
                    <form action="{{ $project->path() }}" method="post">
                        @csrf
                        @method('PATCH')

                        <textarea class="card w-full mb-4" name="notes" style="min-height:200px" placeholder="Anything special that you want to make a note off?">{{ $project->notes }}</textarea>
                        <button class="c-bg-blue text-white font-semibold py-2 px-5 rounded" type="submit">Save</button>
                    </form>

                    @include('errors')
                </div>
            </div>

            <div class="lg:w-1/4 px-3">
                @include('projects.card')
            </div>
        </div>
    </main>
    
@endsection