<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use League\Csv\Reader;
use App\Models\Project;
use App\Models\Building;
use League\Csv\Statement;
use App\Models\BuildingTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


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
    public function upload(Project $project)
    {
        
         return Inertia::render('Building/Task/Import', [
            'project' => $project]);
    }
    public function import(Request $request)
    {

        // Validate the uploaded file
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
            'project_id' => 'required',
        ]);
        $project = Project::findOrFail($request->project_id);
        // dd($project);
        // Load the CSV file
        
      
        $csv = Reader::createFromPath($request->file('csv_file')->getRealPath(), 'r');
        $csv->setHeaderOffset(0); // Set the header offset to read the first row as header
    
        $records = (new Statement())->process($csv);
        $values = iterator_to_array($records); // Convert the iterator to an array
    // dd($values);
        foreach ($values as $record) {
            // Extracting values from the CSV record
            $buildingName = $record['Building']; // Ensure this matches your CSV header
            $taskCode = $record['Task code'];
            $budgetedHours = $record['Budgeted hours'] ?? null;
            $building = Building::where('name', $buildingName)->first();
            // If not, create it
            if (!$building) {
                $building = new Building();
                $building->name = $buildingName;
                $building->is_active = 1;
                $building->project_id = $project->id;
                $building->save();
            }
      
            
            // Prepare task data
            $taskData = [
                'building_id' => $building->id,
                'code' => $taskCode,
                'description' => "No description", // Set to null if not available
                'wages_assigned' =>  $budgetedHours ?? $budgetedHours.numericValue() || 0 , 
                
                
            ];
            $task = BuildingTask::where('code', $taskCode)->first();
            if ($task) {
                // Update the existing task
                $task->update($taskData);
            } else {
                // Create a new task
                $buildingTask = new BuildingTask($taskData);
                $building->tasks()->save($buildingTask);
            }
           

            
           
        }

        return redirect('/project?remember=forget')->with('success', 'Buildings and tasks imported successfully!');
    }

}
