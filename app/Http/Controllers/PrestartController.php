<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Project;
use App\Models\Prestart;
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
     $projects_completed = Project::where('completed', 0)->get();
     $projects_active = Project::where('completed', 1)->get();
    
     // Retrieve search filters from the request
    $workdate = $request->input('workdate');
    $project = $request->input('project');

    
     // Fetch prestarts with project and foreman, applying filters
     $prestarts = Prestart::with(['project', 'foreman', 'prestartSigned.user'])
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
    //  dd($prestarts->toArray());
    // Ensure prestartSigned is an array
$prestarts->getCollection()->transform(function ($prestart) {
    $prestart->workdate = \App\Helpers\DateFormatHelper::formatDate($prestart->workdate);
    $prestart->prestartSigned = $prestart->prestartSigned ?: []; // Ensure it's an array
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
    $projects_completed = Project::where('completed', 0)->get();
    $projects_active = Project::where('completed', 1)->get();
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
        $prestart->load(['project', 'foreman']);

        // Format the workdate
        $formattedDate = DateFormatHelper::formatDate($prestart->workdate);
        // Generate PDF
        $pdf = Pdf::loadView('prestartpdf.pdf', ['prestart' => $prestart, 'formattedDate' => $formattedDate]);

        // Download PDF with a unique filename
        return $pdf->stream('prestart_' . $prestart->id . '.pdf');
    }
    public function uploadSignedPagesPDF(Prestart $prestart) {
        $prestart->load(['project.users']);
        return Inertia::render('Daily-Prestart-Signed/UploadSignedPagesPDF', ['prestart' => $prestart]);
    }
    
}
