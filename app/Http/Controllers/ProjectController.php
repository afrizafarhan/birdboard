<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index', ['projects' => auth()->user()->projects]);
    }

    public function create()
    {
        return view('projects.create');
    }

    public function show(Project $project)
    {
        if(auth()->user()->isNot($project->owner)) abort(403);

        return view('projects.show', ['project' => $project]);
    }

    public function store()
    {
        $project = auth()->user()->projects()->create($this->validateRequest());

        return redirect($project->path());
    }

    public function edit(Project $project)
    {   
        return view('projects.edit', ['project' => $project]);
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $project->update($this->validateRequest());

        return redirect($project->path());
    }

    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'required',
            'descriptions' => 'required',
            'notes' => 'min:3'
        ]);
    }
}
