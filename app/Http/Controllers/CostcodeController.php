<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use League\Csv\Reader;
use App\Models\Costcode;
use League\Csv\Statement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CostcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
    $costcodes = Costcode::with('creator')->get();



    // Return to Inertia with the data
    return Inertia::render('Admin/Costcode/Index', [
        'costcodes' => $costcodes,
        
    ]);
}
   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    return Inertia::render('Admin/Costcode/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'code' => 'required',
            'description' => 'required',
            'unit' => 'required',
            'category_1' => 'nullable|string', // Mark as optional but ensure it's a string if provided
            'category_2' => 'nullable|string', // Mark as optional but ensure it's a string if provided
            'category_3' => 'nullable|string',
            'category_4' => 'nullable|string',
        ]);
    
        // Add the currently authenticated user's ID as created_by
        $data['created_by'] = auth()->id();
    
        // Create a new Costcode record with the validated data
        $costcode = Costcode::create($data);
    
        return redirect()->route('cost-codes.index')->with('success', 'Cost code created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Costcode $costcode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Costcode $costcode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Costcode $costcode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Costcode $costcode)
    {
        //
    }
    public function showUploadForm()
    {
        return Inertia::render('Admin/Costcode/Upload');
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

    // Dump the values to inspect their structure
    // dd($valuesOnly);

    foreach ($records as $record) {
        // Create or update the cost code based on the unique identifier (e.g., code)
        Costcode::updateOrCreate(
            ['code' => $record['Code']], // Assuming 'Code' is the unique identifier in the CSV
            [
                'description' => $record['Description'],
                'unit' => $record['Unit'],
                'category_1' => $record['Category 1'],
                'category_2' => $record['Category 2'],
                'category_3' => $record['Category 3'],
                'category_4' => $record['Category 4'],
                'created_by' => auth()->id(),
            ]
        );
    }

    return redirect()->route('cost-codes.index')->with('success', 'Cost codes imported successfully!');
}
}
