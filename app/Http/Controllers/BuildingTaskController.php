<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Project;
use App\Models\Building;
use App\Models\BuildingTask;
use Illuminate\Http\Request;

class BuildingTaskController extends Controller
{
    public function create(Project $project, Building $building)
    {
        return Inertia::render('Building/Task/Create', [
            'project' => $project,
            'building' => $building,
        ]);
    }

    public function store(Request $request, Project $project, Building $building)
    {
        // Validate the request data
        $data = $request->validate([
            'code' => 'required|string|max:255',
            'description' => 'nullable|string',
            'wages_assigned' => 'nullable|numeric',
            'completed_at' => 'nullable|date',
        ]);

        // Create a new task and associate it with the building
        $buildingTask = new BuildingTask($data);
        $building->tasks()->save($buildingTask);

        // Redirect back with a success message
        return redirect()->route('buildings.index', ['project' => $project->id])->with('success', 'Task created successfully.');
    }

     public function toggleCompletion(Request $request, $id)
    {
        $task = BuildingTask::findOrFail($id);

        if ($task->completed_at) {
            // Set completed_at to null
            $task->completed_at = null;
        } else {
            // Set completed_at to today's date
            $task->completed_at = Carbon::now();
        }

        $task->save();

        
    }
}