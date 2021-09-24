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
    
    public function test_a_user_can_create_project()
    {

        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        
        $this->followingRedirects()->post('/projects', $attributes = Project::factory()->raw())
        ->assertSee($attributes['title'])
        ->assertSee($attributes['descriptions'])
        ->assertSee($attributes['notes']);
    }

    function test_a_user_can_update_a_project()
    {

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = ['title' => 'Changed', 'descriptions' => 'Changed','notes' => 'Changed'])
            ->assertRedirect($project->path());

        $this->get($project->path() . '/edit')->assertOk();

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
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->get($project->path() . '/edit')->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('/login');
    }

    public function test_a_user_can_view_their_project()
    {
        $project = ProjectFactory::create();
        $this->actingAs($project->owner)->get($project->path())->assertSee($project->title)->assertSee($project->descriptions);
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

    function test_a_user_can_update_a_project_general_notes()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)->patch($project->path(), $attributes = ['notes' => 'Changed']);

        $this->assertDatabaseHas('projects', $attributes);
    }

    function test_unauthorized_users_cannot_delete_projects()
    {
        $project = ProjectFactory::create();
        
        $this->delete($project->path())->assertRedirect('/login');

        $user = $this->signIn();

        $this->delete($project->path())->assertStatus(403);

        $project->invite($user);

        $this->actingAs($user)->delete($project->path())->assertStatus(403);
    }

    function test_user_can_delete_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)->delete($project->path())->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    function test_user_can_see_all_projects_they_have_been_invited_to_on_their_dashboard()
    {
        $project = tap(ProjectFactory::create())->invite($this->signIn());
        $this->get('/projects')->assertSee($project->title);
    }
}
