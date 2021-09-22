<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {

        $attributes = request()->validate(['title' => 'required', 'descriptions' => 'required', 'notes' => 'min:3']);

        $project = auth()->user()->projects()->create($attributes);

        return redirect($project->path());
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $project->notes = request('notes');
        $project->save();

        return redirect($project->path());
    }
}
