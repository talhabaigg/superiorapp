<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Project;
use App\Models\MaterialItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RequisitionController extends Controller
{
    public function create() {
        $suppliers = MaterialItem::groupBy('supplier_name')->pluck('supplier_name', 'supplier_name');
        // dd($suppliers);
        $projects_completed = Project::where('completed', 1)->get();
        $projects_active = Project::where('completed', 0)->get();
    
        $items = MaterialItem::all();
        return Inertia('Requisition/Create', ['items' => $items, 'suppliers' => $suppliers, 'projects_completed' => $projects_completed,
        'projects_active' => $projects_active,]);
    }

    public function printPdf(Request $request)
    {
        // dd($request->all());
        // Validate form input fields
        $validated = $request->validate([
            'date_required' => 'required|date',
            'supplier' => 'required|string',
            'project_id' => 'required',
            'site_ref' => 'required|string',
            'delivery_contact' => 'required|string',
            'pickup_by' => 'nullable|string',
            'requested_by' => 'required|string',
            'delivery_to' => 'required|string',
            'notes' => 'nullable|string',
            'req_lines' => 'required',  // Ensure req_lines is an array
            'req_lines.*.item_code' => 'required|string',
            'req_lines.*.description' => 'required|string',
            'req_lines.*.qty' => 'required|numeric',
            'req_lines.*.cost' => 'nullable|numeric',
        ]);

        // Generate a simple PDF from the form data
        $pdf = Pdf::loadView('material-pdf.material-requisition', [
            'date_required' => $validated['date_required'],
            'supplier' => $validated['supplier'],
            'project_id' => $validated['project_id'],
            'site_ref' => $validated['site_ref'],
            'delivery_contact' => $validated['delivery_contact'],
            'pickup_by' => $validated['pickup_by'],
            'requested_by' => $validated['requested_by'],
            'delivery_to' => $validated['delivery_to'],
            'notes' => $validated['notes'],
            'req_lines' => $validated['req_lines'],
        ]);

        // Return the PDF document as a download
        // Define file path and save PDF
     // Define file path and save PDF temporarily
     $fileName = 'material-requisition-' . time() . '.pdf';
     $filePath = storage_path('app/public/' . $fileName); // Save to storage/app/public
     $pdf->save($filePath);

     $tempFilePath = tempnam(sys_get_temp_dir(), 'material_requisition_') . '.pdf';

    // Save the PDF to the temporary file
    $pdf->save($tempFilePath);
 
     // Return the downloadable link to the frontend
     $pdfUrl = asset('storage/' . $fileName); // Generate a public URL for the file
 
     // Redirect to the Inertia component with the PDF URL
     return Inertia('Requisition/Download', ['pdfUrl' => $pdfUrl]);

    
        
    }
}
