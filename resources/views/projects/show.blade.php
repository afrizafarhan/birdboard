@extends('layouts.app')

@section('content') 
    <header class="flex items-center mb-6 py-4">
        <p class="mr-auto text-muted lg:text-lg font-light"><a href="/projects">My Projects</a> / {{ $project->title }}</p>
        <div class="flex items-center">
            @foreach ($project->members as $member)
                <img
                    src="{{ gravatar_url($member->email) }}"
                    alt="{{ $member->name }}'s avatar"
                    class="rounded-full w-8 mr-2">
            @endforeach

            <img
                src="{{ gravatar_url($project->owner->email) }}"
                alt="{{ $project->owner->name }}'s avatar"
                class="rounded-full w-8 mr-2">

                <a href="{{ $project->path().'/edit' }}" class="button">Edit Project</a>
        </div>

    </header>

    
    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-muted font-light text-lg mb-3">Tasks</h2>
                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">
                            <form action="{{ $project->path() . '/tasks/' . $task->id }}" method="POST">
                                @method('PATCH')
                                @csrf
                                <div class="flex">
                                    <input value="{{ $task->body }}" type="text" name="body" class="w-full text-default bg-card {{ $task->completed ? 'line-through text-muted' : '' }}" id="">
                                    <input type="checkbox" name="completed" onchange="this.form.submit()" {{$task->completed ? 'checked' : ''}}>
                                </div>
                            </form>
                        </div>
                    @endforeach
                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="POST">
                            @csrf
                            <input placeholder="Add new task.." type="text" name="body" class="text-default bg-card w-full" id="">
                        </form>
                    </div>
                </div>
                <div class="">
                    <h2 class="text-muted font-light text-lg mb-3">General Notes</h2>
                    
                    <form action="{{ $project->path() }}" method="post">
                        @csrf
                        @method('PATCH')

                        <textarea class="card w-full mb-4 text-default" name="notes" style="min-height:200px" placeholder="Anything special that you want to make a note off?">{{ $project->notes }}</textarea>
                        <button class="button" type="submit">Save</button>
                    </form>

                    @include('errors')
                </div>
            </div>

            <div class="lg:w-1/4 px-3">
                @include('projects.card')
                @include ('projects.activity.card')

                @can('manage', $project)
                    @include('projects.invite')
                @endcan
            </div>
        </div>
    </main>
    
@endsection