<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index', ['projects' => auth()->user()->accessibleProjects()]);
    }

    public function create()
    {
        return view('projects.create');
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', ['project' => $project]);
    }

    public function store(ProjectRequest $request)
    {
        $project = auth()->user()->projects()->create($request->validated());
        
        return redirect($project->path());
    }

    public function edit(Project $project)
    {   
        return view('projects.edit', ['project' => $project]);
    }

    public function update(ProjectUpdateRequest $request,Project $project)
    {
        $project->update($request->validated());

        return redirect($project->path());
    }

    public function destroy(Project $project)
    {
        $this->authorize('manage', $project);

        $project->delete();

        return redirect('/projects');
    }
}
