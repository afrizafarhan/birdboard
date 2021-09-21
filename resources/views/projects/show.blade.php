@extends('layouts.app')

@section('content') 
    <header class="flex items-center mb-3 py-4">
        <p class="mr-auto text-gray-600 lg:text-lg"><a href="/projects">My Projects</a> / {{ $project->title }}</p>
        <a href="/projects/create" class="c-bg-blue text-white font-semibold py-2 px-5 rounded">New Project</a>
    </header>

    
    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-gray-600 font-normal text-lg mb-3">Tasks</h2>
                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">{{ $task->body }}</div>
                    @endforeach
                </div>
                <div class="">
                    <h2 class="text-gray-600 font-normal text-lg mb-3">General Notes</h2>                
                    <textarea class="card w-full" style="min-height:200px">Lorem</textarea>
                </div>
            </div>

            <div class="lg:w-1/4 px-3">
                @include('projects.card')
            </div>
        </div>
    </main>
    
@endsection