<?php

namespace App\Http\Controllers;

use App\Models\SocialProject;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SocialProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projects = SocialProject::paginate(10);
        return view('admin.social_projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.social_projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:planned,active,completed',
            'budget' => 'nullable|numeric|min:0',
        ]);

        SocialProject::create($validated);

        return redirect()->route('social.index')->with('success', 'Projeto social criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SocialProject $social): View
    {
        return view('admin.social_projects.show', compact('social'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocialProject $social): View
    {
        return view('admin.social_projects.edit', compact('social'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SocialProject $social): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:planned,active,completed',
            'budget' => 'nullable|numeric|min:0',
        ]);

        $social->update($validated);

        return redirect()->route('social.index')->with('success', 'Projeto social atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialProject $social): RedirectResponse
    {
        $social->delete();

        return redirect()->route('social.index')->with('success', 'Projeto social excluído com sucesso.');
    }
}
