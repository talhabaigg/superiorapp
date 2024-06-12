<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectUserController extends Controller
{
    public function index(Project $project)
    {
        
        $users = $project->users;
        $allUsers = User::all();
        return Inertia::render('ProjectUsers/Index', [
        'project' => $project,
        'users' => $users,
        'allUsers' => $allUsers
    ]);
}

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $project->users()->attach($request->user_id);

        return redirect()->back()->with('success', 'User assigned to project successfully');
    }

    public function destroy(Project $project, User $user)
    {
        $project->users()->detach($user->id);

        return redirect()->back()->with('success', 'User removed from project successfully');
    }
}
