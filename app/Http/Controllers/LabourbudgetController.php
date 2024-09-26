<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Project;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use App\Models\TimesheetTask;
use Illuminate\Support\Facades\DB;

class LabourbudgetController extends Controller
{
    public function index(Request $request) {
        $projects = Project::all();
        // $startDateString = '21-09-2024'; // Original format
        // $endDateString = '26-09-2024';   // Original format
        // $weekEnding = $request->query('week_ending', null);
        $weekEnding = $request->query('week_ending');
        $startDateString = $request->query('startFrom', '');
        $endDateString = $request->query('selectedEnddate', '');
        $project = $request->query('projectId', '');
        // dd($startDateString, $endDateString, $project);
        if ($weekEnding) {
            // Convert weekEnding to a DateTime object
            $endDate = Carbon::createFromFormat('d-m-Y', $weekEnding);
            $startDate = $endDate->copy()->subDays(7); // Subtract 7 days for start date
            $startDateFormatted = $startDate->format('d-m-Y');
            $endDateFormatted = $endDate->format('d-m-Y');

            // Format start and end dates to string
            $startDateString = $startDateFormatted; // Format start date
            $endDateString = $endDateFormatted; // Format end date
            // dd($startDateString, $endDateString);
        } else {
            // If no weekEnding, use the provided query parameters for start and end dates
            $startDateString = $request->query('startFrom', null);
            $endDateString = $request->query('selectedEnddate', null);
    
            // If only start date or only end date is provided, return an error
            if ($startDateString && !$endDateString) {
                return response()->json(['message' => 'Both start and end dates are required.'], 400);
            } elseif (!$startDateString && $endDateString) {
                return response()->json(['message' => 'Both start and end dates are required.'], 400);
            }
        }

        // Proceed with the query only if both dates are set
    if ($startDateString && $endDateString) {
        $tasks = TimesheetTask::with(['timesheet.user', 'buildingTask'])
            ->select('timesheet_id', 'code_id', 'hours')
            ->whereHas('timesheet', function($query) use ($startDateString, $endDateString) {
                $query->whereBetween('date', [$startDateString, $endDateString]);
            })
            ->where('project_id', $project)
            ->get();
    
        // Transforming the data to include user name and building task code
        $results = $tasks->map(function ($task) {
            return [
                'user_name' => $task->timesheet->user->name,
                'code' => $task->buildingTask->code,
                'hours' => $task->hours
            ];
        });

        $summary = $results->groupBy('code')->map(function ($group) {
            return [
                'user_name' => $group->first()['user_name'],
                'code' => $group->first()['code'],
                'hours' => $group->sum('hours')
            ];
        })->sortBy('user_name')->values();
    } else {
        $summary = []; // No data to return if no valid dates are provided
    }


    return Inertia::render('Labour/Index', [
        'projects' => $projects, 
        'results' => $summary, 
        'projectId' => $project, 
        'startFrom' => $startDateString, 
        'selectedEnddate' => $endDateString,
        'weekEnding' => $weekEnding,
    ]);
    }
}
