<?php

namespace App\Http\Controllers;

use App\Models\MeetingMinute;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MeetingMinuteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = MeetingMinute::query()
            ->when($request->search, function ($q, $search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                          ->orWhere('meeting_type', 'like', "%{$search}%");
                });
            })
            ->when($request->meeting_type, function ($q, $type) {
                $q->where('meeting_type', $type);
            })
            ->when($request->status, function ($q, $status) {
                $q->where('status', $status);
            })
            ->when($request->date_from, function ($q, $date) {
                $q->whereDate('meeting_date', '>=', $date);
            })
            ->when($request->date_to, function ($q, $date) {
                $q->whereDate('meeting_date', '<=', $date);
            })
            ->orderBy('meeting_date', 'desc')
            ->orderBy('created_at', 'desc');

        $minutes = $query->paginate(15);

        return view('admin.administration.meeting-minutes.index', compact('minutes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.administration.meeting-minutes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meeting_type' => 'nullable|string|max:100',
            'meeting_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'participants' => 'nullable|array',
            'participants.*' => 'string|max:255',
            'content' => 'required|string',
            'decisions' => 'nullable|string',
            'action_items' => 'nullable|string',
            'status' => 'nullable|string|in:draft,approved,archived',
            'approved_by' => 'nullable|string|max:255',
            'approved_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        MeetingMinute::create($validated);

        return redirect()
            ->route('admin.administration.meeting-minutes.index')
            ->with('success', 'Ata registrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MeetingMinute $minute): View
    {
        return view('admin.administration.meeting-minutes.show', compact('minute'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MeetingMinute $minute): View
    {
        return view('admin.administration.meeting-minutes.edit', compact('minute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MeetingMinute $minute): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meeting_type' => 'nullable|string|max:100',
            'meeting_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'participants' => 'nullable|array',
            'participants.*' => 'string|max:255',
            'content' => 'required|string',
            'decisions' => 'nullable|string',
            'action_items' => 'nullable|string',
            'status' => 'nullable|string|in:draft,approved,archived',
            'approved_by' => 'nullable|string|max:255',
            'approved_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $minute->update($validated);

        return redirect()
            ->route('admin.administration.meeting-minutes.index')
            ->with('success', 'Ata atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MeetingMinute $minute): RedirectResponse
    {
        $minute->delete();

        return redirect()
            ->route('admin.administration.meeting-minutes.index')
            ->with('success', 'Ata excluída com sucesso!');
    }

    /**
     * Approve minute.
     */
    public function approve(Request $request, MeetingMinute $minute): RedirectResponse
    {
        $validated = $request->validate([
            'approved_by' => 'nullable|string|max:255',
        ]);

        $minute->update([
            'status' => 'approved',
            'approved_by' => $validated['approved_by'] ?? auth()->user()?->name ?? 'Sistema',
            'approved_at' => now(),
        ]);

        return redirect()
            ->route('admin.administration.meeting-minutes.index')
            ->with('success', 'Ata aprovada!');
    }

    /**
     * Archive minute.
     */
    public function archive(MeetingMinute $minute): RedirectResponse
    {
        $minute->update(['status' => 'archived']);

        return redirect()
            ->route('admin.administration.meeting-minutes.index')
            ->with('success', 'Ata arquivada!');
    }

    /**
     * Restore minute from archive.
     */
    public function restore(MeetingMinute $minute): RedirectResponse
    {
        $minute->update(['status' => 'approved']);

        return redirect()
            ->route('admin.administration.meeting-minutes.index')
            ->with('success', 'Ata restaurada!');
    }
}
