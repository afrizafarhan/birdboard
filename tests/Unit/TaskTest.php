<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase,WithFaker;
    
    function test_belongs_to_a_project()
    {
        $task = Task::factory()->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }

    function test_has_a_path()
    {
        $task = Task::factory()->create();

        $this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }
}