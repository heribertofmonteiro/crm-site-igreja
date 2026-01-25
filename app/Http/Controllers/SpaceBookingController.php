<?php

namespace App\Http\Controllers;

use App\Models\SpaceBooking;
use App\Models\User;
use Illuminate\Http\Request;

class SpaceBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spaceBookings = SpaceBooking::with('user')->paginate(10);
        return view('admin.patrimony.space_bookings.index', compact('spaceBookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.patrimony.space_bookings.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'space_name' => 'required|string|max:255',
            'booked_by' => 'required|exists:users,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'purpose' => 'required|string',
            'status' => 'required|in:pending,approved,rejected,cancelled',
            'notes' => 'nullable|string',
        ]);

        SpaceBooking::create($request->all());

        return redirect()->route('patrimony.space_bookings.index')->with('success', 'Space booking created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SpaceBooking $spaceBooking)
    {
        return view('admin.patrimony.space_bookings.show', compact('spaceBooking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SpaceBooking $spaceBooking)
    {
        $users = User::all();
        return view('admin.patrimony.space_bookings.edit', compact('spaceBooking', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SpaceBooking $spaceBooking)
    {
        $request->validate([
            'space_name' => 'required|string|max:255',
            'booked_by' => 'required|exists:users,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'purpose' => 'required|string',
            'status' => 'required|in:pending,approved,rejected,cancelled',
            'notes' => 'nullable|string',
        ]);

        $spaceBooking->update($request->all());

        return redirect()->route('patrimony.space_bookings.index')->with('success', 'Space booking updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SpaceBooking $spaceBooking)
    {
        $spaceBooking->delete();

        return redirect()->route('patrimony.space_bookings.index')->with('success', 'Space booking deleted successfully.');
    }
}
