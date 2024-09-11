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
            'members' => 'required|array',
            'members.*' => 'exists:users,id',
        ]);

        // Sync the selected users as project members
        $project->users()->sync($request->members);

        // Redirect with a success message
        return redirect()->route('project.show', $project)
                        ->with('success', 'Project members updated successfully!');
    }

    public function destroy(Project $project, User $user)
    {
        $project->users()->detach($user->id);

        return redirect()->back()->with('success', 'User removed from project successfully');
    }

    public function edit(Project $project) {
        $allUsers= User::all();
        $users = $project->users->pluck('id')->toArray();
        return Inertia::render('ProjectUsers/Edit', [
            'project' => $project,
            'existingMembers' => $users,
            'allUsers' => $allUsers
        ]);
    }
}
