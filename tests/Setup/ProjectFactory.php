<?php

namespace Tests\Setup;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ProjectFactory{
    protected $user;
    protected $tasksCount = 0;

    function withTasks($count)
    {
        $this->tasksCount = $count;

        return $this;
    }

    function ownedBy($user)
    {
        $this->user = $user;

        return $this;
    }

    function create()
    {
        $project = Project::factory()->create([
            'owner_id' => $this->user ?? User::factory(),
        ]);

        Task::factory()->create([
            'project_id' => $project->id
        ]);

        return $project;
    }
}