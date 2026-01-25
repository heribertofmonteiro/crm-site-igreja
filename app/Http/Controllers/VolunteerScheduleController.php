<?php

namespace App\Http\Controllers;

use App\Models\VolunteerSchedule;
use Illuminate\Http\Request;

class VolunteerScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = VolunteerSchedule::with(['volunteerRole', 'user'])->get();
        return response()->json($schedules);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'volunteer_role_id' => 'required|exists:volunteer_roles,id',
            'user_id' => 'required|exists:users,id',
            'event_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'in:pending,confirmed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $schedule = VolunteerSchedule::create($request->all());
        return response()->json($schedule, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $schedule = VolunteerSchedule::with(['volunteerRole', 'user'])->findOrFail($id);
        return response()->json($schedule);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $schedule = VolunteerSchedule::findOrFail($id);

        $request->validate([
            'volunteer_role_id' => 'sometimes|exists:volunteer_roles,id',
            'user_id' => 'sometimes|exists:users,id',
            'event_date' => 'sometimes|date',
            'start_time' => 'sometimes|date_format:H:i',
            'end_time' => 'sometimes|date_format:H:i|after:start_time',
            'status' => 'sometimes|in:pending,confirmed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $schedule->update($request->all());
        return response()->json($schedule);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = VolunteerSchedule::findOrFail($id);
        $schedule->delete();
        return response()->json(['message' => 'Schedule deleted successfully']);
    }
}
