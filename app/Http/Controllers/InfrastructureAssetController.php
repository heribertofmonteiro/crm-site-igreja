<?php

namespace App\Http\Controllers;

use App\Models\InfrastructureAsset;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InfrastructureAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $assets = InfrastructureAsset::latest()->paginate(15);

        return view('admin.it.infrastructure.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.it.infrastructure.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive,maintenance',
            'location' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'warranty_expiry' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        InfrastructureAsset::create($validated);

        return redirect()->route('it.infrastructure.index')
            ->with('success', 'Ativo de infraestrutura criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InfrastructureAsset $infrastructure): View
    {
        return view('admin.it.infrastructure.show', compact('infrastructure'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InfrastructureAsset $infrastructure): View
    {
        return view('admin.it.infrastructure.edit', compact('infrastructure'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InfrastructureAsset $infrastructure): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive,maintenance',
            'location' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'warranty_expiry' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $infrastructure->update($validated);

        return redirect()->route('it.infrastructure.index')
            ->with('success', 'Ativo de infraestrutura atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InfrastructureAsset $infrastructure): RedirectResponse
    {
        $infrastructure->delete();

        return redirect()->route('it.infrastructure.index')
            ->with('success', 'Ativo de infraestrutura removido com sucesso.');
    }
}
