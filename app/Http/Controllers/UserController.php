<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Str;
use App\Models\Employeetype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Get the search query from the request (if provided)
    $searchQuery = $request->query('searchQuery');
    $employeeType = $request->query('selectedEmployeeType');
    $subsidiaryType = $request->query('subsidiaryType');
    $statusType = $request->query('selectedStatusType');

   
    $employee_types = User::pluck('employee_type')->unique();
    $users = User::query()
        ->when($searchQuery, function ($query, $searchQuery) {
            $query->where('name', 'like', "%{$searchQuery}%");
        })
        ->when($employeeType, function ($query, $employeeType) {
            $query->where('employee_type', $employeeType);
        })
        ->when($subsidiaryType, function ($query, $subsidiaryType) {
            $query->where('subsidiary', $subsidiaryType);
        })
        ->when($statusType !== null, function ($query) use ($statusType) {
            $query->where('is_active', $statusType);
        })
        ->paginate(25);

    // Return the view with filtered/paginated users
    return inertia('User/Index', [
        'users' => $users,
        'filters' => [
            'searchQuery' => $searchQuery, // Pass the search query back to the view
            'selectedEmployeeType' => $employeeType,
            'selectedStatusType'=> $statusType,
        ],
        'employee_types'=> $employee_types,
    ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employee_types = Employeetype::all();
        $projects = Project::all();
        return inertia('User/Create',['employee_types' => $employee_types, 'projects'=> $projects]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'phone_number' => 'required|string|max:15', // Customize as needed
        'email' => 'required|email|unique:users,email', // Ensure email is unique
        'employee_type' => 'required|string', // Adjust as necessary (string, enum, etc.)
        'superior_id' => 'nullable', // Ensure it's a valid user ID if provided
        'greeline_id' => 'nullable|string|max:255', // Optional field, adjust max length as needed
    ]);

    // Auto-generate a password
    $generatedPassword = Str::password(12); // Generates a 12-character complex password
    
    // Create the user and hash the generated password
    $user = User::create([
        'name' => $request->name,
        'phone_number' => $request->phone_number,
        'email' => $request->email,
        'employee_type' => $request->employee_type,
        'superior_id' => $request->superior_id,
        'greeline_id' => $request->greeline_id,
        'password' => Hash::make($generatedPassword), // Hash the generated password
    ]);

    // Optionally, return the generated password if you need to send it to the user
    // This is just an example; typically you'd send this via email or other means
    return redirect()->route('users.index')->with('success', 'user has been added');
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

    // Get the authenticated user's permissions
    $permissions = $user->getAllPermissions()->pluck('name');

    $today = now()->format('d-m-Y');

    // Load relationships
    $user->load('projects', 'timesheets');

        
 
        return inertia('User/Show', [
            'user' =>  $user,
            'today' => $today,
            'permissions' => $permissions,
           ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findorfail($id);
        $userPermissions  = $user->getAllPermissions()->pluck('name')->toArray();
       $employee_types = Employeetype::all();
       $permissions = Permission::all();
       

        return inertia('User/Edit', ['user' => $user, 'employee_types' => $employee_types, 'permissions' => $permissions, 'userPermissions' => $userPermissions]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user= User::findorfail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            // Add any other validation rules for user fields
            'userPermissions' => 'array', // Validate permissions as an array
            'userPermissions.*' => 'exists:permissions,name', // Ensure each permission exists in the permissions table
        ]);
        // dd($request->userPermissions);
        $user->update($request->except('userPermissions'));
        
        // If permissions are provided, assign them
        if ($request->has('userPermissions')) {
            $user->syncPermissions($request->input('userPermissions'));  // Sync with the array of permissions
        }
       return redirect()->route('users.index')->with('success', 'user has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->toggleStatus();

        return redirect()->route('users.index')->with('success', 'Employee is now inactive.!');
    }
}