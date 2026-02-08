<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class EventRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = EventRegistration::with(['event', 'user', 'member'])
            ->when($request->event_id, function ($q, $eventId) {
                $q->where('event_id', $eventId);
            })
            ->when($request->status, function ($q, $status) {
                $q->where('status', $status);
            })
            ->when($request->search, function ($q, $search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('attendee_name', 'like', "%{$search}%")
                          ->orWhere('attendee_email', 'like', "%{$search}%")
                          ->orWhere('attendee_phone', 'like', "%{$search}%");
                });
            })
            ->when($request->date_from, function ($q, $date) {
                $q->whereDate('created_at', '>=', $date);
            })
            ->when($request->date_to, function ($q, $date) {
                $q->whereDate('created_at', '<=', $date);
            })
            ->orderBy('created_at', 'desc');

        $registrations = $query->paginate(15);
        $events = Event::active()->orderBy('start_time')->get();

        return view('admin.events.registrations.index', compact('registrations', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $events = Event::active()->upcoming()->orderBy('start_time')->get();

        return view('admin.events.registrations.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'attendee_name' => 'required|string|max:255',
            'attendee_email' => 'nullable|email|max:255',
            'attendee_phone' => 'nullable|string|max:50',
            'attendee_document' => 'nullable|string|max:50',
            'quantity' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
            'status' => 'nullable|string|in:pending,confirmed,cancelled,waitlist',
        ]);

        $event = Event::findOrFail($validated['event_id']);

        // Check capacity
        $currentRegistrations = EventRegistration::where('event_id', $event->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->sum('quantity');

        $quantity = $validated['quantity'] ?? 1;
        $newStatus = 'pending';

        if ($event->capacity && ($currentRegistrations + $quantity) > $event->capacity) {
            $newStatus = 'waitlist';
        }

        $validated['status'] = $validated['status'] ?? $newStatus;

        EventRegistration::create($validated);

        return redirect()
            ->route('admin.events.registrations.index')
            ->with('success', 'Inscrição realizada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventRegistration $registration): View
    {
        $registration->load(['event']);

        return view('admin.events.registrations.show', compact('registration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventRegistration $registration): View
    {
        $events = Event::active()->orderBy('start_time')->get();

        return view('admin.events.registrations.edit', compact('registration', 'events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventRegistration $registration): RedirectResponse
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'attendee_name' => 'required|string|max:255',
            'attendee_email' => 'nullable|email|max:255',
            'attendee_phone' => 'nullable|string|max:50',
            'attendee_document' => 'nullable|string|max:50',
            'quantity' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
            'status' => 'nullable|string|in:pending,confirmed,cancelled,waitlist',
        ]);

        $registration->update($validated);

        return redirect()
            ->route('admin.events.registrations.index')
            ->with('success', 'Inscrição atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventRegistration $registration): RedirectResponse
    {
        $registration->delete();

        return redirect()
            ->route('admin.events.registrations.index')
            ->with('success', 'Inscrição excluída com sucesso!');
    }

    /**
     * Update status of the registration.
     */
    public function updateStatus(Request $request, EventRegistration $registration): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,confirmed,cancelled,waitlist',
        ]);

        $registration->update($validated);

        return redirect()
            ->route('admin.events.registrations.index')
            ->with('success', 'Status atualizado com sucesso!');
    }

    /**
     * Confirm registration.
     */
    public function confirm(EventRegistration $registration): RedirectResponse
    {
        $registration->update(['status' => 'confirmed']);

        return redirect()
            ->route('admin.events.registrations.index')
            ->with('success', 'Inscrição confirmada!');
    }

    /**
     * Cancel registration.
     */
    public function cancel(EventRegistration $registration): RedirectResponse
    {
        $registration->update(['status' => 'cancelled']);

        return redirect()
            ->route('admin.events.registrations.index')
            ->with('success', 'Inscrição cancelada!');
    }
}
