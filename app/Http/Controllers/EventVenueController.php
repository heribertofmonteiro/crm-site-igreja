<?php

namespace App\Http\Controllers;

use App\Models\EventVenue;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventVenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = EventVenue::query()
            ->when($request->search, function ($q, $search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            })
            ->when($request->status !== null, function ($q) use ($request) {
                $q->where('is_active', $request->status === 'true');
            })
            ->when($request->min_capacity, function ($q, $capacity) {
                $q->where('capacity', '>=', $capacity);
            })
            ->when($request->city, function ($q, $city) {
                $q->where('city', 'like', "%{$city}%");
            })
            ->orderBy('name');

        $venues = $query->paginate(15);

        return view('admin.events.venues.index', compact('venues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.events.venues.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:20',
            'capacity' => 'nullable|integer|min:0',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'facilities' => 'nullable|array',
            'facilities.*' => 'string',
            'is_active' => 'boolean',
        ]);

        EventVenue::create($validated);

        return redirect()
            ->route('admin.events.venues.index')
            ->with('success', 'Local cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventVenue $venue): View
    {
        $venue->load(['events' => function ($query) {
            $query->upcoming()->limit(10);
        }]);

        return view('admin.events.venues.show', compact('venue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventVenue $venue): View
    {
        return view('admin.events.venues.edit', compact('venue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventVenue $venue): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:20',
            'capacity' => 'nullable|integer|min:0',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'facilities' => 'nullable|array',
            'facilities.*' => 'string',
            'is_active' => 'boolean',
        ]);

        $venue->update($validated);

        return redirect()
            ->route('admin.events.venues.index')
            ->with('success', 'Local atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventVenue $venue): RedirectResponse
    {
        if ($venue->events()->exists()) {
            return redirect()
                ->route('admin.events.venues.index')
                ->with('error', 'Não é possível excluir este local pois há eventos associados.');
        }

        $venue->delete();

        return redirect()
            ->route('admin.events.venues.index')
            ->with('success', 'Local excluído com sucesso!');
    }

    /**
     * Toggle active status of the venue.
     */
    public function toggleActive(EventVenue $venue): RedirectResponse
    {
        $venue->is_active = !$venue->is_active;
        $venue->save();

        $status = $venue->is_active ? 'ativado' : 'desativado';

        return redirect()
            ->route('admin.events.venues.index')
            ->with('success', "Local {$status} com sucesso!");
    }
}
