<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return inertia('User/Create');
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
    public function show($id)
    {
        $user = User::findOrFail($id);

        $today = Carbon::now()->format('d-m-Y');
 
        // dd($today);
        $user->load('projects');
        $user->load('timesheets');
        return inertia('User/Show', [
            'user' =>  $user,
            'today' => $today,
           ]
        );
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

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->toggleStatus();

        return redirect()->route('users.index')->with('success', 'Employee is now inactive.!');
    }
}