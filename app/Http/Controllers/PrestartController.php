<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Project;
use App\Models\Activity;
use App\Models\Incident;
use App\Models\Prestart;
use iio\libmergepdf\Pages;
use iio\libmergepdf\Merger;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\WorkdatesHelper;
use App\Helpers\DateFormatHelper;

class PrestartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    //This allows to retrieve last work days in date format with Australia timezone.
    $workdays = WorkdatesHelper::getLastWorkdays(400, 'Australia/Sydney');

     // Fetch all projects where 'completed' is 0
     $projects_completed = Project::where('completed', 1)->get();
     $projects_active = Project::where('completed', 0)->get();
    
     // Retrieve search filters from the request
    $workdate = $request->input('workdate');
    $project = $request->input('project');

    
     // Fetch prestarts with project and foreman, applying filters
     $prestarts = Prestart::with(['project', 'foreman', 'prestartSigned.user', 'prestartAbsent.user'])
     ->when($workdate, function ($query, $workdate) {
         // Filter by workdate
         return $query->whereDate('workdate', $workdate);
     })
     ->when($project, function ($query, $project_id) {
         // Filter by project_id
         return $query->where('project_id', $project_id);
     })
     ->orderByDesc('created_at')
     ->paginate(20);

    
$prestarts->getCollection()->transform(function ($prestart) {
    $prestart->workdate = \App\Helpers\DateFormatHelper::formatDate($prestart->workdate);
    $prestart->prestartSigned = $prestart->prestartSigned ?: []; // Ensure it's an array
    $prestart->prestartAbsent = $prestart->prestartAbsent ?: [];
    return $prestart;
    });


    // Return to Inertia with the data
    return Inertia::render('Daily-Prestarts/Index', [
        'workdays' => $workdays,
        'projects_completed' => $projects_completed,
        'projects_active' => $projects_active,
        'prestarts' => $prestarts, // Pass the workdays array to the Vue component
        'workdate' =>  $workdate,
        'project' => $project
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    // Fetch all projects where 'completed' is 0
    $projects_completed = Project::where('completed', 1)->get();
    $projects_active = Project::where('completed', 0)->get();
    $foremen = User::where('employee_type', 'Foreman' )->get();
    
    // Pass the projects to the Inertia view
    return Inertia::render('Daily-Prestarts/Create', [
        'projects_completed' => $projects_completed,
        'projects_active' => $projects_active,
        'foremen' => $foremen
    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'prestart.workdate' => 'required|date',
            'prestart.project_id' => 'required',
            'prestart.foreman_id' => 'required',
            'prestart.weather' => 'nullable|string', // Mark as optional but ensure it's a string if provided
            'prestart.weather_impact' => 'nullable|string', // Mark as optional but ensure it's a string if provided
            'activities' => 'required|array',
            'incidents' => 'required|array',
            'activities.*.name' => 'required|string',
            'incidents.*.name' => 'required|string',
       
        ]);

        // Create a new Paycheck
        $prestart = Prestart::create($data['prestart']);

        // Create Activity records
        foreach ($data['activities'] as $activity) {
            $prestart->activities()->create($activity);
        }

        // Create Incident records
        foreach ($data['incidents'] as $incident) {
            $prestart->incidents()->create($incident);
        }

        return redirect()->route('daily-prestarts.index')->with('success', 'Prestart created successfully!');
    }
    public function duplicate($prestartId)
{
    // Find the original prestart record
    $originalPrestart = Prestart::findOrFail($prestartId);

    // Create a new prestart record with today's date
    $newPrestart = $originalPrestart->replicate();
    $newPrestart->workdate = Carbon::today()->format('Y-m-d'); // Use the format expected by your database
    $newPrestart->save();

    // Duplicate associated activities
    foreach ($originalPrestart->activities as $activity) {
        $newActivity = $activity->replicate();
        $newActivity->prestart_id = $newPrestart->id;
        $newActivity->save();
    }

    // Duplicate associated incidents
    foreach ($originalPrestart->incidents as $incident) {
        $newIncident = $incident->replicate();
        $newIncident->prestart_id = $newPrestart->id;
        $newIncident->save();
    }

    // Redirect to the index route with a success message
    return redirect()->route('daily-prestarts.edit', ['daily_prestart' => $newPrestart->id])
                     ->with('success', 'Prestart duplicated successfully!');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $prestart = Prestart::with('activities', 'incidents')->findOrFail($id);
        $projects_completed = Project::where('completed', 1)->get();
        $projects_active = Project::where('completed', 0)->get();
        $foremen = User::where('employee_type', 'Foreman' )->get();
        // dd($prestart);
        // Pass the projects to the Inertia view
        return Inertia::render('Daily-Prestarts/Edit', [
            'projects_completed' => $projects_completed,
            'projects_active' => $projects_active,
            'foremen' => $foremen,
            'prestart' => $prestart,
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Validate the request
        $request->validate([
            
            'prestart' => 'required|array',
            'activities' => 'array',
            'incidents' => 'array',
        ]);
    
       // Retrieve the prestart record
    $prestart = Prestart::findOrFail($request->daily_prestart);

    // Update prestart details
    $prestart->update($request->prestart);

     // Update or create activities
     if ($request->has('activities')) {
        $activityIds = [];
        foreach ($request->activities as $activity) {
            $updatedActivity = Activity::updateOrCreate(
                ['prestart_id' => $prestart->id, 'id' => $activity['id'] ?? null],
                $activity
            );
            $activityIds[] = $updatedActivity->id;
        }

        // Delete activities that are not in the request
        Activity::where('prestart_id', $prestart->id)
            ->whereNotIn('id', $activityIds)
            ->delete();
    }

     // Update or create incidents
     if ($request->has('incidents')) {
        $incidentIds = [];
        foreach ($request->incidents as $incident) {
            $updatedIncident = Incident::updateOrCreate(
                ['prestart_id' => $prestart->id, 'id' => $incident['id'] ?? null],
                $incident
            );
            $incidentIds[] = $updatedIncident->id;
        }

        // Delete incidents that are not in the request
        Incident::where('prestart_id', $prestart->id)
            ->whereNotIn('id', $incidentIds)
            ->delete();
    }

    return redirect()->route('daily-prestarts.index')->with('success', 'Pre-start saved successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    $prestart = Prestart::findOrFail($id);
    $prestart->delete();

    return redirect()->route('daily-prestarts.index')
    ->with('success', 'Prestart deleted');
}
 

    public function getLastWorkdays($numDays = 100)
    {
        $workdays = [];
        $currentDate = new DateTime();
        
        while (count($workdays) < $numDays) {
            $currentDay = $currentDate->format('N'); // Get day of the week (1 = Monday, ..., 7 = Sunday)

            if ($currentDay >= 1 && $currentDay <= 5) {
                $workdays[] = $currentDate->format('Y-m-d');
            }

            $currentDate->modify('-1 day');
        }
        
        return $workdays; // Return the array directly
    }

    public function signsheetTemplate(Prestart $prestart)
    {
        // Load related data
        $prestart->load(['project', 'project.users']);

        // Format the workdate
        $formattedDate = DateFormatHelper::formatDate($prestart->workdate);
        // Generate PDF
        $pdf = Pdf::loadView('prestartpdf.signsheetpdftemplate', ['prestart' => $prestart, 'formattedDate' => $formattedDate]);

        // Download PDF with a unique filename
        return $pdf->stream('prestart_' . $prestart->id . '.pdf');
    }
    public function prestartPdf(Prestart $prestart)
{
    // Load related data
    $prestart->load(['project', 'foreman', 'prestartSigned']);

    // Format the workdate
    $formattedDate = DateFormatHelper::formatDate($prestart->workdate);

    // Generate PDF and save it to a temporary file
    $pdf = Pdf::loadView('prestartpdf.pdf', ['prestart' => $prestart, 'formattedDate' => $formattedDate]);
    $pdfFilePath = storage_path('app/public/prestart_' . $prestart->id . '.pdf');
    $pdf->save($pdfFilePath);

    if ($prestart->pdf_path) {
        // Merge PDFs if $prestart->pdf_path is not NULL
        $mergedPdfPath = $this->mergePdfs($pdfFilePath, storage_path('app/public/' . $prestart->pdf_path));
    } else {
        // No merging, just use the generated PDF
        $mergedPdfPath = $pdfFilePath;
    }

    // Return the final PDF for download
    // return response()->download($mergedPdfPath)->deleteFileAfterSend(true);
    // return $mergedPdfPath->stream('prestart_' . $prestart->id . '.pdf');
    // Return the final PDF for inline viewing
    return response()->file($mergedPdfPath, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . basename($mergedPdfPath) . '"',
    ]);
}

    protected function mergePdfs($pdfFilePath, $prestartPdfPath)
{
    // Create a new Merger instance and add files
    $merger = new Merger;
    $merger->addFile($pdfFilePath);
    $merger->addFile($prestartPdfPath);

    // Merge the PDFs
    $createdPdf = $merger->merge();

    // Save the merged PDF to a temporary file
    $mergedPdfFilePath = storage_path('app/public/merged_prestart_' . basename($pdfFilePath));
    file_put_contents($mergedPdfFilePath, $createdPdf);

    return $mergedPdfFilePath;
}
    public function uploadSignedPagesPDF(Prestart $prestart) {
        $prestart->load(['project.users']);
        return Inertia::render('Daily-Prestart-Signed/UploadSignedPagesPDF', ['prestart' => $prestart]);
    }
    
}
