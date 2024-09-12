<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Prestart;
use Illuminate\Http\Request;
use App\Models\PrestartAbsent;

class AbsentController extends Controller
{
    public function index() {
        // Fetch all prestarts with related project and prestartAbsent entries (including users)
        $prestarts = Prestart::with(['project', 'prestartAbsent.user', 'prestartAbsent.user.projects'])->get();
        $prestartAbsents = PrestartAbsent::with(['user', 'user.projects'])->get();

        // Pass the data to the Inertia component
        return Inertia::render('Absent/Index', [
            'absentees' => $prestartAbsents,
        ]);
    }
    public function manage(Prestart $prestart) {
        $prestart->load(['project', 'prestartAbsent.user']);


        return Inertia::render('Absent/Manage', [
            'prestart' => $prestart,
        ]);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'prestart_id' => 'required|exists:prestarts,id',
            'absentees' => 'required|array',
            'absentees.*.user_id' => 'required|exists:users,id',
            'absentees.*.reason' => 'nullable|string',
            'absentees.*.notes' => 'nullable|string',
        ]);

        // Loop through each absentee and store/update their information
        foreach ($validatedData['absentees'] as $absentee) {
            PrestartAbsent::updateOrCreate(
                [
                    'prestart_id' => $validatedData['prestart_id'],
                    'user_id' => $absentee['user_id'],
                ],
                [
                    'reason' => $absentee['reason'] ?? null,
                    'notes' => $absentee['notes'] ?? null,
                ]
            );
        }

        // Redirect back or wherever necessary
        return redirect()->route('daily-prestarts.index', $validatedData['prestart_id'])
            ->with('success', 'Absentee data saved successfully.');
    }
}
