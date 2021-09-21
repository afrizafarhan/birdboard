<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;
use App\Models\User;

class ManageProjectTest extends TestCase
{
    use WithFaker,RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_user_can_create_project()
    {
        $attributes = [
            'title' => $this->faker->sentence(),
            'descriptions' => $this->faker->paragraph(),
        ];
    
        $this->signIn();
        
       $this->post('/projects', $attributes)->assertRedirect('/projects');
       $this->get('/projects')->assertSee($attributes['title']);
       $this->get('/projects/create')->assertStatus(200);
       $this->assertDatabaseHas('projects', $attributes);
    }

    public function test_a_projects_requires_a_title_and_a_descriptions(){

        $this->signIn();

        $attributes = Project::factory()->raw(['title' => '', 'descriptions' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors(['title','descriptions']);
    }

    public function test_guest_cannot_manage_project()
    {
        $project = Project::factory()->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('/login');
    }
    
    public function test_a_user_can_view_their_project()
    { 
        //if error show in test
        //this is because route wildcard
        
        $this->be(User::factory()->create());

        $project = Project::factory()->create(['owner_id' => auth()->user()->id]);

        $this->get($project->path())->assertSee($project->title)->assertSee($project->descriptions);
    }

    public function test_an_authenticated_user_cannot_view_the_projecs_of_others()
    {
        $this->be(User::factory()->create());

        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);
    }

}
