<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use League\Csv\Reader;
use App\Models\Costcode;
use League\Csv\Statement;
use App\Models\MaterialItem;
use Illuminate\Http\Request;

class MaterialItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = MaterialItem::all();



    // Return to Inertia with the data
    return Inertia::render('Admin/Material/Index', [
        'items' => $items,
        
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
    public function show(MaterialItem $materialItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaterialItem $materialItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaterialItem $materialItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaterialItem $materialItem)
    {
        //
    }

    public function showUploadForm()
    {
        return Inertia::render('Admin/Material/Upload');
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
        // $costCode = $record['Cost Code'];
        // $formattedCostCode = substr($costCode, 0, 2) . '-' . substr($costCode, 2);
        MaterialItem::updateOrCreate(
            ['code' => $record['Item code']], 
            [
             
                'description' => $record['Item Description'],
                'supplier_name' => $record['Suppplier Name'],
                'costcode' => $record['Cost Code'],
                
            ]
        );
    }

    return redirect()->route('material-items.index')->with('success', 'Material imported successfully!');
}
}
