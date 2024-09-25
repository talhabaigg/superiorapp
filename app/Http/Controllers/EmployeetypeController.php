<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use League\Csv\Reader;
use App\Models\Costcode;
use League\Csv\Statement;
use App\Models\Employeetype;
use Illuminate\Http\Request;

class EmployeetypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employee_types = Employeetype::with(['creator', 'costcode'])->get();



    // Return to Inertia with the data
    return Inertia::render('Admin/Employeetype/Index', [
        'employee_types' => $employee_types,
        
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Employeetype $employeetype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employeetype $employeetype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employeetype $employeetype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employeetype $employeetype)
    {
        //
    }

    public function showUpload()
    {
        return Inertia::render('Admin/Employeetype/Upload');
    }

    public function import(Request $request)
{
    // dd('test');
    $request->validate([
        'csvFile' => 'required|file|mimes:csv,txt|max:2048',
    ]);


    // Load the CSV file
    $csv = Reader::createFromPath($request->file('csvFile')->getRealPath(), 'r');
    $csv->setHeaderOffset(0); // Set the header offset to read the first row as header

    $records = (new Statement())->process($csv);
    $values = iterator_to_array($records); // Convert the iterator to an array

    // Extract values only (excluding the headers)
    $valuesOnly = array_map(function ($record) {
        return array_values($record);
    }, $values);
    // dd($valuesOnly);

    // Dump the values to inspect their structure
    // dd($valuesOnly);

    foreach ($records as $record) {
        // Create or update the cost code based on the unique identifier (e.g., code)
        $costcode = Costcode::where('code', $record['Cost code'])->first();
        if ($costcode) {
            // Create or update the employee type with the correct costcode_id
            Employeetype::updateOrCreate(
                ['name' => $record['Name']], // Assuming 'Name' is the unique field for employee type
                [
                    'costcode_id' => $costcode->id,
                    'full_time' => $record['Full time'] === 'Yes' ? 1 : 0, // Assuming 'Full time' is Yes/No
                    'created_by' => auth()->id(),
                ]
            );
        }
    }

    return redirect()->route('cost-codes.index')->with('success', 'Cost codes imported successfully!');
}
}
