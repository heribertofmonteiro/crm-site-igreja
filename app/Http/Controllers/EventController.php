<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use App\Models\EventVenue;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $query = Event::with(['eventType', 'venue', 'creator'])
            ->when($request->search, function ($q, $search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($request->status, function ($q, $status) {
                $q->where('status', $status);
            })
            ->when($request->event_type_id, function ($q, $typeId) {
                $q->where('event_type_id', $typeId);
            })
            ->when($request->venue_id, function ($q, $venueId) {
                $q->where('venue_id', $venueId);
            })
            ->latest('start_time');

        $events = $query->paginate(15);
        $eventTypes = EventType::active()->orderBy('name')->get();
        $venues = EventVenue::active()->orderBy('name')->get();
        
        return view('admin.events.index', compact('events', 'eventTypes', 'venues'));
    }

    public function create(): View
    {
        $eventTypes = EventType::active()->orderBy('name')->get();
        $venues = EventVenue::active()->orderBy('name')->get();
        
        return view('admin.events.create', compact('eventTypes', 'venues'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_type_id' => 'required|exists:event_types,id',
            'venue_id' => 'nullable|exists:event_venues,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'is_all_day' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contact_info' => 'nullable|array',
            'ticket_price' => 'nullable|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'is_public' => 'boolean',
            'requires_registration' => 'boolean',
            'registration_deadline' => 'nullable|date|before:start_time',
        ]);

        $data = $request->except(['image']);
        $data['slug'] = Str::slug($request->title);
        $data['created_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $data['image'] = $imagePath;
        }

        Event::create($data);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Evento criado com sucesso!');
    }

    public function show(Event $event): View
    {
        $event->load(['eventType', 'venue', 'creator', 'registrations' => function ($query) {
            $query->latest()->limit(10);
        }, 'resources' => function ($query) {
            $query->latest()->limit(5);
        }]);
        
        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event): View
    {
        $eventTypes = EventType::active()->orderBy('name')->get();
        $venues = EventVenue::active()->orderBy('name')->get();
        
        return view('admin.events.edit', compact('event', 'eventTypes', 'venues'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_type_id' => 'required|exists:event_types,id',
            'venue_id' => 'nullable|exists:event_venues,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'is_all_day' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contact_info' => 'nullable|array',
            'ticket_price' => 'nullable|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'is_public' => 'boolean',
            'requires_registration' => 'boolean',
            'registration_deadline' => 'nullable|date|before:start_time',
        ]);

        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            // Remove old image if exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            
            $imagePath = $request->file('image')->store('events', 'public');
            $data['image'] = $imagePath;
        }

        $event->update($data);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(Event $event): RedirectResponse
    {
        if ($event->registrations()->exists()) {
            return back()->withErrors(['error' => 'Não é possível excluir um evento com inscrições.']);
        }

        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Evento excluído com sucesso!');
    }

    public function duplicate(Event $event): RedirectResponse
    {
        $newEvent = $event->replicate([
            'slug',
            'current_participants',
            'status',
        ]);
        
        $newEvent->title = $event->title . ' (Cópia)';
        $newEvent->slug = Str::slug($newEvent->title);
        $newEvent->status = 'planned';
        $newEvent->current_participants = 0;
        $newEvent->created_by = auth()->id();
        $newEvent->save();

        return redirect()
            ->route('admin.events.edit', $newEvent)
            ->with('success', 'Evento duplicado com sucesso!');
    }

    public function calendar(Request $request): View
    {
        $query = Event::with(['eventType', 'venue'])
            ->public()
            ->where('status', '!=', 'cancelled');

        if ($request->month) {
            $query->whereMonth('start_time', $request->month);
        }
        
        if ($request->year) {
            $query->whereYear('start_time', $request->year);
        }

        $events = $query->get()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_time->toISOString(),
                'end' => $event->end_time->toISOString(),
                'backgroundColor' => $event->eventType->color,
                'borderColor' => $event->eventType->color,
                'url' => route('admin.events.show', $event),
                'extendedProps' => [
                    'eventType' => $event->eventType->name,
                    'venue' => $event->venue?->name,
                    'status' => $event->status,
                ],
            ];
        });

        return view('admin.events.calendar', compact('events'));
    }

    public function updateStatus(Request $request, Event $event): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:planned,ongoing,completed,cancelled',
        ]);

        $event->update(['status' => $request->status]);

        return back()->with('success', 'Status do evento atualizado!');
    }
}
