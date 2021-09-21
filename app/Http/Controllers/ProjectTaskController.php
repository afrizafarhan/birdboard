<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectTaskController extends Controller
{
    public function store(Project $project)
    {
        $attribute = request()->validate([
            'body' => 'required'
        ]);

        $attribute['project_id'] = $project->id;

        $project->addTask($attribute);

        return redirect($project->path());
    }
}
