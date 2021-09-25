@extends('layouts.app')

@section('content')

    <header class="flex items-center mb-3 py-4">
        <h2 class="mr-auto text-muted text-base font-light lg:text-lg">My Projects</h2>
        <a href="/projects/create" class="c-bg-blue text-white font-semibold py-2 px-5 rounded">Add Project</a>
    </header>
    
    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse ($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                @include('projects.card')
            </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </main>
@endsection