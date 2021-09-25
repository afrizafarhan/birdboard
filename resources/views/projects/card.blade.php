    <div class="card mt-9 flex flex-col" style="height: 200px">
        <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 pl-4 border-accent-light">
            <a class="text-default no-underline" href="{{ $project->path() }}">{{ $project->title }}</a>
        </h3> 
        <div class="mb-4 flex-1">
            {{ $project->descriptions }}
        </div>
        @can('manage', $project)
            <footer>
                <form method="POST" action="{{ $project->path() }}" class="text-right">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="text-xs text-white font-semibold py-2 px-5 rounded bg-red-500">Delete</button>
                </form>
            </footer>
        @endcan
    </div>
