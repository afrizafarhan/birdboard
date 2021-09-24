<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInvitationRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectInvitationController extends Controller
{
    function store(Project $project, ProjectInvitationRequest $request)
    {
        try{
            $user = User::whereEmail($request->email)->first();

            $project->invite($user);
            
            return redirect($project->path());
        }catch(\Throwable $e){
            dd($e->getMessage());
        }
    }
}
