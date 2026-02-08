<?php

namespace App\Http\Controllers;

use App\Models\EventResource;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = EventResource::query()
            ->when($request->search, function ($q, $search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($request->type, function ($q, $type) {
                $q->where('type', $type);
            })
            ->when($request->status !== null, function ($q) use ($request) {
                $q->where('is_available', $request->status === 'true');
            })
            ->orderBy('name');

        $resources = $query->paginate(15);

        return view('admin.events.resources.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.events.resources.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|in:equipment,food,decoration,transportation,other',
            'quantity' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'is_available' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        EventResource::create($validated);

        return redirect()
            ->route('admin.events.resources.index')
            ->with('success', 'Recurso cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventResource $resource): View
    {
        return view('admin.events.resources.show', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventResource $resource): View
    {
        return view('admin.events.resources.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventResource $resource): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|in:equipment,food,decoration,transportation,other',
            'quantity' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'is_available' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $resource->update($validated);

        return redirect()
            ->route('admin.events.resources.index')
            ->with('success', 'Recurso atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventResource $resource): RedirectResponse
    {
        $resource->delete();

        return redirect()
            ->route('admin.events.resources.index')
            ->with('success', 'Recurso excluído com sucesso!');
    }

    /**
     * Toggle availability status.
     */
    public function toggleAvailability(EventResource $resource): RedirectResponse
    {
        $resource->is_available = !$resource->is_available;
        $resource->save();

        return redirect()
            ->route('admin.events.resources.index')
            ->with('success', 'Disponibilidade atualizada!');
    }

    /**
     * Update quantity.
     */
    public function updateQuantity(Request $request, EventResource $resource): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $resource->update($validated);

        return redirect()
            ->route('admin.events.resources.index')
            ->with('success', 'Quantidade atualizada!');
    }
}
