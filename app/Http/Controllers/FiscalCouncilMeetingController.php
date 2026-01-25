<?php

namespace App\Http\Controllers;

use App\Models\FiscalCouncilMeeting;
use Illuminate\Http\Request;

class FiscalCouncilMeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meetings = FiscalCouncilMeeting::orderBy('meeting_date', 'desc')->paginate(10);
        return view('finance.fiscal_council_meetings.index', compact('meetings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('finance.fiscal_council_meetings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'meeting_date' => 'required|date',
            'attendees' => 'nullable|string',
            'minutes' => 'nullable|string',
            'decisions' => 'nullable|string',
            'status' => 'required|in:scheduled,held,cancelled',
        ]);

        $data = $request->all();
        if ($request->attendees) {
            $data['attendees'] = array_filter(array_map('trim', explode("\n", $request->attendees)));
        }

        FiscalCouncilMeeting::create($data);

        return redirect()->route('fiscal-council-meetings.index')->with('success', 'Reunião criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FiscalCouncilMeeting $fiscalCouncilMeeting)
    {
        return view('finance.fiscal_council_meetings.show', compact('fiscalCouncilMeeting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FiscalCouncilMeeting $fiscalCouncilMeeting)
    {
        return view('finance.fiscal_council_meetings.edit', compact('fiscalCouncilMeeting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FiscalCouncilMeeting $fiscalCouncilMeeting)
    {
        $request->validate([
            'meeting_date' => 'required|date',
            'attendees' => 'nullable|string',
            'minutes' => 'nullable|string',
            'decisions' => 'nullable|string',
            'status' => 'required|in:scheduled,held,cancelled',
        ]);

        $data = $request->all();
        if ($request->attendees) {
            $data['attendees'] = array_filter(array_map('trim', explode("\n", $request->attendees)));
        }

        $fiscalCouncilMeeting->update($data);

        return redirect()->route('fiscal-council-meetings.index')->with('success', 'Reunião atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FiscalCouncilMeeting $fiscalCouncilMeeting)
    {
        $fiscalCouncilMeeting->delete();

        return redirect()->route('fiscal-council-meetings.index')->with('success', 'Reunião excluída com sucesso.');
    }
}
