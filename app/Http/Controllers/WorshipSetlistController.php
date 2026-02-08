<?php

namespace App\Http\Controllers;

use App\Models\WorshipSetlist;
use App\Models\WorshipSong;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WorshipSetlistController extends Controller
{
    public function index(Request $request): View
    {
        $query = WorshipSetlist::with(['creator', 'event', 'songs'])
            ->when($request->date, function ($q, $date) {
                $q->whereDate('date', $date);
            })
            ->when($request->month, function ($q, $month) {
                $q->whereMonth('date', $month);
            })
            ->when($request->year, function ($q, $year) {
                $q->whereYear('date', $year);
            })
            ->latest('date');

        $setlists = $query->paginate(15);
        
        return view('admin.worship.setlists.index', compact('setlists'));
    }

    public function create(): View
    {
        $songs = WorshipSong::active()->orderBy('title')->get();
        $events = Event::latest()->get();
        
        return view('admin.worship.setlists.create', compact('songs', 'events'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'date' => 'required|date',
            'event_id' => 'nullable|exists:events,id',
            'theme' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'songs' => 'required|array',
            'songs.*' => 'exists:worship_songs,id',
        ]);

        $setlist = WorshipSetlist::create([
            'church_event_id' => $request->event_id,
            'date' => $request->date,
            'theme' => $request->theme,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
        ]);

        // Attach songs with order
        if ($request->has('songs')) {
            $order = 0;
            foreach ($request->songs as $songId) {
                $setlist->songs()->attach($songId, [
                    'order' => $order,
                    'notes' => $request->song_notes[$songId] ?? null,
                    'key_override' => $request->key_overrides[$songId] ?? null,
                ]);
                $order++;
            }
        }

        return redirect()
            ->route('admin.worship.setlists.index')
            ->with('success', 'Setlist criada com sucesso!');
    }

    public function show(WorshipSetlist $worshipSetlist): View
    {
        $worshipSetlist->load(['creator', 'event', 'songs' => function ($query) {
            $query->orderBy('order');
        }]);
        
        return view('admin.worship.setlists.show', compact('worshipSetlist'));
    }

    public function edit(WorshipSetlist $worshipSetlist): View
    {
        $worshipSetlist->load(['songs' => function ($query) {
            $query->orderBy('order');
        }]);
        
        $songs = WorshipSong::active()->orderBy('title')->get();
        $events = Event::latest()->get();
        
        return view('admin.worship.setlists.edit', compact('worshipSetlist', 'songs', 'events'));
    }

    public function update(Request $request, WorshipSetlist $worshipSetlist): RedirectResponse
    {
        $request->validate([
            'date' => 'required|date',
            'event_id' => 'nullable|exists:events,id',
            'theme' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'songs' => 'nullable|array',
            'songs.*' => 'exists:worship_songs,id',
        ]);

        $worshipSetlist->update([
            'church_event_id' => $request->event_id,
            'date' => $request->date,
            'theme' => $request->theme,
            'notes' => $request->notes,
        ]);

        // Update songs in setlist
        if ($request->has('songs')) {
            $worshipSetlist->songs()->detach();
            $order = 0;
            foreach ($request->songs as $songId) {
                $worshipSetlist->songs()->attach($songId, [
                    'order' => $order,
                    'notes' => $request->song_notes[$songId] ?? null,
                    'key_override' => $request->key_overrides[$songId] ?? null,
                ]);
                $order++;
            }
        }

        return redirect()
            ->route('admin.worship.setlists.index')
            ->with('success', 'Setlist atualizada com sucesso!');
    }

    public function destroy(WorshipSetlist $worshipSetlist): RedirectResponse
    {
        $worshipSetlist->songs()->detach();
        $worshipSetlist->delete();

        return redirect()
            ->route('admin.worship.setlists.index')
            ->with('success', 'Setlist excluída com sucesso!');
    }

    public function print(WorshipSetlist $worshipSetlist): View
    {
        $worshipSetlist->load(['songs' => function ($query) {
            $query->orderBy('order');
        }]);
        
        return view('admin.worship.setlists.print', compact('worshipSetlist'));
    }

    public function duplicate(WorshipSetlist $worshipSetlist): RedirectResponse
    {
        $newSetlist = WorshipSetlist::create([
            'church_event_id' => null,
            'date' => now()->addDays(7)->format('Y-m-d'),
            'theme' => $worshipSetlist->theme . ' (Cópia)',
            'notes' => $worshipSetlist->notes,
            'created_by' => auth()->id(),
        ]);

        // Duplicate songs with same order
        foreach ($worshipSetlist->songs()->orderBy('order')->get() as $song) {
            $newSetlist->songs()->attach($song->id, [
                'order' => $song->pivot->order,
                'notes' => $song->pivot->notes,
                'key_override' => $song->pivot->key_override,
            ]);
        }

        return redirect()
            ->route('admin.worship.setlists.edit', $newSetlist)
            ->with('success', 'Setlist duplicada com sucesso!');
    }
}
