<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Project;
use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
       
        $buildings = $project->buildings()->with('tasks')->get();
      
        // dd($buildings->toArray());
       
        return Inertia::render('Building/Index', [
        'project' => $project,
        'buildings' => $buildings,
    
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        // Validate the request data
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new building and associate it with the project
        $building = new Building($data);
        $project->buildings()->save($building);

        // Redirect back with a success message
        return redirect()->route('buildings.index', $project)->with('success', 'Building created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Building $building)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Building $building)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building)
    {
        //
    }
}
