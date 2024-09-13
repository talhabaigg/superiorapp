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
    // Validate the incoming request data
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'project_id' => 'required|exists:projects,id',
        'date' => 'required|date',
        'start_time.hour' => 'required|min:0|max:23',
        'start_time.minute' => 'required|min:0|max:59',
        'end_time.hour' => 'required|min:0|max:23',
        'end_time.minute' => 'required|min:0|max:59',
       
        'description' => 'nullable|string',
    ]);

    // Prepare the start_time and end_time by combining hour and minute components
    $start_time = sprintf('%02d:%02d', $request->input('start_time_hour'), $request->input('start_time_minute'));
    $end_time = sprintf('%02d:%02d', $request->input('end_time_hour'), $request->input('end_time_minute'));
dd($start_time);
    // Prepare the data for storage
    $data = $request->only([
        'user_id',
        'project_id',
        'date',
        'hours_worked',
        'description'
    ]);

    // Add the formatted times to the data array
    $data['start_time'] = $start_time;
    $data['end_time'] = $end_time;

    // Convert the date format for storage
    $data['date'] = Carbon::createFromFormat('Y-m-d', $request->input('date'))->format('d-m-Y');

    // Define the unique attributes to check for existence
    $attributes = [
        'user_id' => $data['user_id'],
        'project_id' => $data['project_id'],
        'date' => $data['date'],
    ];

    // Use updateOrCreate to either update the existing record or create a new one
    Timesheet::updateOrCreate($attributes, $data);

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Timesheet saved successfully.');
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

//     public function index(Request $request)
// {
//     // Get the week_ending date from the query parameters or default to this week's Friday
//     $today = Carbon::now();
//     $weekEnding = $today->isFriday() ? $today->format('d-m-Y') : $today->next(Carbon::FRIDAY)->format('d-m-Y');

//     // Override the weekEnding if provided in the query parameters
//     $weekEnding = $request->query('week_ending', $weekEnding);

//     // Get the usertype from the query parameters (1 for active, 0 for inactive)
//     $usertype = $request->query('usertype', null);
//     $projectName = $request->query('projectName', null);
//     $employeeType = $request->query('employeeType', null);

//     // Parse the week_ending date and calculate the start date of the week
//     $endOfWeek = Carbon::createFromFormat('d-m-Y', $weekEnding);
//     $startOfWeek = $endOfWeek->copy()->subDays(6);

//     // Generate the dates for the week
//     $weekDates = collect(range(0, 6))->map(function($day) use ($startOfWeek) {
//         return $startOfWeek->copy()->addDays($day)->format('d-m-Y');
//     });
//     $projects = Project::all();
//     $employeeTypes = User::select('employee_type')->distinct()->pluck('employee_type');
//     // Fetch users with their timesheets for the specified week and calculate hours worked
//     // Fetch users with their timesheets for the specified week and calculate hours worked
//     $usersQuery = User::whereHas('timesheets', function($query) use ($startOfWeek, $endOfWeek, $projectName) {
//         $query->whereBetween('date', [$startOfWeek->format('d-m-Y'), $endOfWeek->format('d-m-Y')]);
//         if ($projectName !== null) {
//             $query->where('project_id', $projectName);
//         }
//     })->with(['timesheets' => function($query) use ($startOfWeek, $endOfWeek, $projectName) {
//         $query->whereBetween('date', [$startOfWeek->format('d-m-Y'), $endOfWeek->format('d-m-Y')]);
//         if ($projectName !== null) {
//             $query->where('project_id', $projectName);
//         }
//     }]);

//     // Filter users based on the usertype if provided
//     if ($usertype !== null) {
//         $usersQuery->where('is_active', $usertype);
//     }
//     // Filter employee Type based on the usertype if provided
//     if ($employeeType !== null) {
//         $usersQuery->where('employee_type', $employeeType);
//     }
  

//     $usersData = $usersQuery->get()->map(function ($user) use ($weekDates) {
//         $hoursWorked = $weekDates->mapWithKeys(function($date) use ($user) {
//             $timesheet = $user->timesheets->firstWhere('date', $date);
//             return [$date => $timesheet ? $timesheet->hours_worked : ''];
//         });

//         return [
//             'id' => $user->id,
//             'name' => $user->name,
//             'employee_type' => $user->employee_type,
//             'superior_id' => $user->superior_id,
//             'is_active' => $user->is_active,
//             'hours_worked' => $hoursWorked,
//         ];
//     });

//     // Pass the users, weekDates, weekEnding, and selectedUserType to the view
//     return inertia('Timesheet/Index', [
//         'users' => $usersData,
//         'weekDates' => $weekDates,
//         'weekEnding' => $weekEnding,
//         'selectedUserType' => $usertype,
//         'projectName' => $projectName,
//         'projects' => $projects,
//         'employeeTypes' => $employeeTypes,
//         'employeeType' => $employeeType,
//     ]);
// }
public function index(Request $request)
{
    // Fetch filtering parameters from the request
    $weekEnding = $this->getWeekEnding($request);
    $usertype = $request->query('usertype', null);
    $projectName = $request->query('projectName', null);
    $employeeType = $request->query('employeeType', null);

    // Calculate the start and end of the week based on the weekEnding date
    [$startOfWeek, $endOfWeek] = $this->getWeekStartAndEndDates($weekEnding);

    // Generate all dates for the week
    $weekDates = $this->generateWeekDates($startOfWeek);

    // Fetch projects and employee types for the filters
    $projects = Project::all();
    $employeeTypes = $this->getEmployeeTypes();

    // Fetch users with timesheets and apply filters
    $usersData = $this->fetchUsersWithTimesheets($startOfWeek, $endOfWeek, $projectName, $usertype, $employeeType, $weekDates);

    // Return data to the view
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

private function getWeekEnding(Request $request)
{
    // Determine the default week-ending date (Friday of this week)
    $today = Carbon::now();
    $defaultWeekEnding = $today->isFriday() ? $today->format('d-m-Y') : $today->next(Carbon::FRIDAY)->format('d-m-Y');

    // Allow the week-ending date to be overridden by query parameters
    return $request->query('week_ending', $defaultWeekEnding);
}

private function getWeekStartAndEndDates($weekEnding)
{
    // Parse the week-ending date and calculate the start of the week (7 days prior)
    $endOfWeek = Carbon::createFromFormat('d-m-Y', $weekEnding);
    $startOfWeek = $endOfWeek->copy()->subDays(6);

    return [$startOfWeek, $endOfWeek];
}

private function generateWeekDates($startOfWeek)
{
    // Generate a collection of dates for the entire week
    return collect(range(0, 6))->map(fn($day) => $startOfWeek->copy()->addDays($day)->format('d-m-Y'));
}

private function getEmployeeTypes()
{
    // Get distinct employee types from the User model
    return User::select('employee_type')->distinct()->pluck('employee_type');
}

private function fetchUsersWithTimesheets($startOfWeek, $endOfWeek, $projectName, $usertype, $employeeType, $weekDates)
{
    // Build the query to fetch users and their timesheets based on the filters
    $usersQuery = User::whereHas('timesheets', function ($query) use ($startOfWeek, $endOfWeek, $projectName) {
        // Filter timesheets within the specified week and project (if provided)
        $query->whereBetween('date', [$startOfWeek->format('d-m-Y'), $endOfWeek->format('d-m-Y')]);
        if ($projectName !== null) {
            $query->where('project_id', $projectName);
        }
    })->with(['timesheets' => function ($query) use ($startOfWeek, $endOfWeek, $projectName) {
        // Filter timesheets within the specified week and project (if provided)
        $query->whereBetween('date', [$startOfWeek->format('d-m-Y'), $endOfWeek->format('d-m-Y')]);
        if ($projectName !== null) {
            $query->where('project_id', $projectName);
        }
    }]);

    // Apply additional filters for usertype and employee type
    if ($usertype !== null) {
        $usersQuery->where('is_active', $usertype);
    }

    if ($employeeType !== null) {
        $usersQuery->where('employee_type', $employeeType);
    }

    // Fetch users and map their timesheets
    return $usersQuery->get()->map(fn($user) => $this->mapUserTimesheets($user, $weekDates));
}

private function mapUserTimesheets($user, $weekDates)
{
    // Map hours worked for each date in the week
    $hoursWorked = $weekDates->mapWithKeys(function ($date) use ($user) {
        $timesheet = $user->timesheets->firstWhere('date', $date);
        return [$date => $timesheet ? $timesheet->hours_worked : ''];
    });

    $startTime = $weekDates->mapWithKeys(function ($date) use ($user) {
        $timesheet = $user->timesheets->firstWhere('date', $date);
        return [$date => $timesheet ? $timesheet->start_time : ''];
    });
    $endTime = $weekDates->mapWithKeys(function ($date) use ($user) {
        $timesheet = $user->timesheets->firstWhere('date', $date);
        return [$date => $timesheet ? $timesheet->end_time : ''];
    });

    // Return the structured data for the user
    return [
        'id' => $user->id,
        'name' => $user->name,
        'employee_type' => $user->employee_type,
        'superior_id' => $user->superior_id,
        'is_active' => $user->is_active,
        'hours_worked' => $hoursWorked,
        'start_time' => $startTime,
        'end_time' => $endTime,
    ];
}

public function weeklyEdit(Request $request)
{
    // Fetch the week-ending date using the helper function
    $weekEnding = $this->getWeekEnding($request);

    // Calculate the start and end of the week using the helper function
    [$startOfWeek, $endOfWeek] = $this->getWeekStartAndEndDates($weekEnding);

    // Generate all dates for the week using the helper function
    $weekDates = $this->generateWeekDates($startOfWeek);

    // Get the authenticated user
    $user = auth()->user();

    // Fetch timesheets for the user and map the data
    $mappedTimesheets = $this->mapUserTimesheets($user, $weekDates);

    // Return data to the view
    return inertia('Timesheet/Edit', [
        'weekEnding' => $weekEnding,
        'weekDates' => $weekDates,
        'timesheets' => $mappedTimesheets, // Pass the mapped timesheets data to the view
        'user' => $user,
    ]);
}  
public function showTimesheet($id, $date)
{
    // Attempt to fetch the existing timesheet
    $timesheet = Timesheet::where('user_id', $id)->where('date', $date)->first();
    $user = User::where('id', $id)->with('projects.buildings.tasks')->first();

    // Initialize default values for start_time and end_time
    $startHour = $startMinute = $endHour = $endMinute = null;
   
    if ($timesheet) {
        // Split start_time into hours and minutes
        $startTimeParts = explode(':', $timesheet->start_time);
        $startHour = $startTimeParts[0];
        $startMinute = $startTimeParts[1];

        // Split end_time into hours and minutes
        $endTimeParts = explode(':', $timesheet->end_time);
        $endHour = $endTimeParts[0];
        $endMinute = $endTimeParts[1];
    }
    
    // Pass the timesheet data to the view
    return inertia('Timesheet/Show', [
        'timesheet' => [
            'start_time' => [
                'hour' => $startHour,
                'minute' => $startMinute,
            ],
            'end_time' => [
                'hour' => $endHour,
                'minute' => $endMinute,
            ],
        ],
        'userId' => $id,
        'date' => $date,
        'user' => $user,
    
    ]);

}
}
