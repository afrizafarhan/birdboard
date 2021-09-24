<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory,RecordActivity;

    protected $guarded = ['id'];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function addTask($body)
    {
        return $this->tasks()->create($body);
    }

    function invite(User $user)
    {
        $this->members()->attach($user);
    }

    function members()
    {
        return $this->belongsToMany(User::class, 'project_members')->withTimestamps();
    }
}
