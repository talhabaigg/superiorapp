<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Project;
use App\Models\Timesheet;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'hours_worked' => 'required|numeric',
            'description' => 'nullable|string',
        ]);
    
        $data = $request->all();
        $data['date'] = Carbon::createFromFormat('Y-m-d', $request->date)->format('d-m-Y');
    
        Timesheet::create($data);
    
        return redirect()->back()->with('success', 'Timesheet created successfully.');
    }

    public function create()
    {

       
        $projects = Project::all();
        $users =  User::all();
   
        return Inertia::render('Timesheet/Create', [
        
        'users' => $users,
        'projects' => $projects
    ]);
    }

    public function index(Request $request)
{
    // Get the week_ending date from the query parameters or default to this week's Friday
    $today = Carbon::now();
    $weekEnding = $today->isFriday() ? $today->format('d-m-Y') : $today->next(Carbon::FRIDAY)->format('d-m-Y');

    // Override the weekEnding if provided in the query parameters
    $weekEnding = $request->query('week_ending', $weekEnding);

    // Get the usertype from the query parameters (1 for active, 0 for inactive)
    $usertype = $request->query('usertype', null);
    $projectName = $request->query('projectName', null);
    $employeeType = $request->query('employeeType', null);

    // Parse the week_ending date and calculate the start date of the week
    $endOfWeek = Carbon::createFromFormat('d-m-Y', $weekEnding);
    $startOfWeek = $endOfWeek->copy()->subDays(6);

    // Generate the dates for the week
    $weekDates = collect(range(0, 6))->map(function($day) use ($startOfWeek) {
        return $startOfWeek->copy()->addDays($day)->format('d-m-Y');
    });
    $projects = Project::all();
    $employeeTypes = User::select('employee_type')->distinct()->pluck('employee_type');
    // Fetch users with their timesheets for the specified week and calculate hours worked
    // Fetch users with their timesheets for the specified week and calculate hours worked
    $usersQuery = User::whereHas('timesheets', function($query) use ($startOfWeek, $endOfWeek, $projectName) {
        $query->whereBetween('date', [$startOfWeek->format('d-m-Y'), $endOfWeek->format('d-m-Y')]);
        if ($projectName !== null) {
            $query->where('project_id', $projectName);
        }
    })->with(['timesheets' => function($query) use ($startOfWeek, $endOfWeek, $projectName) {
        $query->whereBetween('date', [$startOfWeek->format('d-m-Y'), $endOfWeek->format('d-m-Y')]);
        if ($projectName !== null) {
            $query->where('project_id', $projectName);
        }
    }]);

    // Filter users based on the usertype if provided
    if ($usertype !== null) {
        $usersQuery->where('is_active', $usertype);
    }
    // Filter employee Type based on the usertype if provided
    if ($employeeType !== null) {
        $usersQuery->where('employee_type', $employeeType);
    }
  

    $usersData = $usersQuery->get()->map(function ($user) use ($weekDates) {
        $hoursWorked = $weekDates->mapWithKeys(function($date) use ($user) {
            $timesheet = $user->timesheets->firstWhere('date', $date);
            return [$date => $timesheet ? $timesheet->hours_worked : ''];
        });

        return [
            'id' => $user->id,
            'name' => $user->name,
            'employee_type' => $user->employee_type,
            'superior_id' => $user->superior_id,
            'is_active' => $user->is_active,
            'hours_worked' => $hoursWorked,
        ];
    });

    // Pass the users, weekDates, weekEnding, and selectedUserType to the view
    return inertia('Timesheet/Index', [
        'users' => $usersData,
        'weekDates' => $weekDates,
        'weekEnding' => $weekEnding,
        'selectedUserType' => $usertype,
        'projectName' => $projectName,
        'projects' => $projects,
        'employeeTypes' => $employeeTypes,
        'employeeType' => $employeeType,
    ]);
}

public function weeklyEdit(request $request) {
    // Get the week_ending date from the query parameters or default to this week's Friday
    $today = Carbon::now();
    $weekEnding = $today->isFriday() ? $today->format('d-m-Y') : $today->next(Carbon::FRIDAY)->format('d-m-Y');

    // Override the weekEnding if provided in the query parameters
    $weekEnding = $request->query('week_ending', $weekEnding);

    // Parse the week_ending date and calculate the start date of the week
    $endOfWeek = Carbon::createFromFormat('d-m-Y', $weekEnding);
    $startOfWeek = $endOfWeek->copy()->subDays(6);

    // Generate the dates for the week
    $weekDates = collect(range(0, 6))->map(function($day) use ($startOfWeek) {
        return $startOfWeek->copy()->addDays($day)->format('d-m-Y');
    });

    return inertia('Timesheet/Edit', [
        'weekEnding' => $weekEnding,
        'weekDates' => $weekDates,
        
    ]);
}
      
}
