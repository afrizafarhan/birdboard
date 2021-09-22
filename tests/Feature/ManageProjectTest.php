<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Support\Str;
class ManageProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_user_can_create_project()
    {

        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence(),
            'descriptions' => $this->faker->sentence(),
            'notes' => 'General Notes.'
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['descriptions'])
            ->assertSee($attributes['notes']);
    }

    function test_a_user_can_update_a_project()
    {

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)->patch($project->path(), $attributes = ['notes' => 'Changed'])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);
    }

    public function test_a_projects_requires_a_title_and_a_descriptions()
    {

        $this->signIn();

        $attributes = Project::factory()->raw(['title' => '', 'descriptions' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors(['title', 'descriptions']);
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
        $project = ProjectFactory::create();
        $this->actingAs($project->owner)->get($project->path())->assertSee($project->title)->assertSee(Str::limit($project->descriptions,100));
    }

    public function test_an_authenticated_user_cannot_view_the_projecs_of_others()
    {
        $this->signIn();
        $project = ProjectFactory::create();
        $this->get($project->path())->assertStatus(403);
    }

    public function test_an_authenticated_user_cannot_update_the_projecs_of_others()
    {
        $this->signIn();
        $project = ProjectFactory::create();
        $this->patch($project->path())->assertStatus(403);
    }
}
