<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;

class ProjectTaskController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('update', $project);

        $attribute = request()->validate([
            'body' => 'required'
        ]);

        $project->addTask($attribute);

        return redirect($project->path());
    }

    public function update(Project $project, Task $task){

        $this->authorize('update', $task->project);

        request()->validate(['body' => 'required']);

        $task->body = request('body');
        $task->completed = request()->has('completed');
        $task->save();

        return redirect($project->path());
    }
}
