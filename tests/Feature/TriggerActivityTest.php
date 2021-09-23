<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;

class TrigerActivityTest extends TestCase
{
    use RefreshDatabase;

    function test_create_a_project()
    {
        $project = ProjectFactory::create();
        $this->assertCount(1, $project->activity);

        $this->assertEquals('created', $project->activity[0]->description);
    }

    function test_updating_a_project()
    {
        $project = ProjectFactory::create();

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);

    }

    function test_creating_new_task()
    {
        $project = ProjectFactory::create();

        $project->addTask(['body' => 'Some Task']);
        $this->assertCount(2, $project->activity);
        $this->assertEquals('created_task', $project->activity->last()->description);
    }
    function test_completing_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => true
        ]);

        $this->assertCount(3, $project->activity);
        $this->assertEquals('completed_task', $project->activity->last()->description);
    }
    function test_incompleting_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => true
        ]);

        $this->assertCount(3, $project->activity);
        
        $this->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => false
        ]);

        $project->refresh();
        
        $this->assertCount(4, $project->activity);

        $this->assertEquals('incompleted_task', $project->activity->last()->description);
    }
}