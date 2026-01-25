<?php

namespace App\Http\Controllers;

use App\Models\MissionProject;
use App\Models\Missionary;
use Illuminate\Http\Request;

class MissionProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = MissionProject::with('missionary')->paginate(10);
        return view('admin.missions.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $missionaries = Missionary::all();
        return view('admin.missions.projects.create', compact('missionaries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'budget' => 'nullable|numeric|min:0',
            'missionary_id' => 'required|exists:missionaries,id',
            'status' => 'required|in:planning,active,completed,cancelled',
        ]);

        MissionProject::create($request->all());

        return redirect()->route('missions.projects.index')->with('success', 'Projeto missionário criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MissionProject $project)
    {
        $project->load('missionary');
        return view('admin.missions.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MissionProject $project)
    {
        $missionaries = Missionary::all();
        return view('admin.missions.projects.edit', compact('project', 'missionaries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MissionProject $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'budget' => 'nullable|numeric|min:0',
            'missionary_id' => 'required|exists:missionaries,id',
            'status' => 'required|in:planning,active,completed,cancelled',
        ]);

        $project->update($request->all());

        return redirect()->route('missions.projects.index')->with('success', 'Projeto missionário atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MissionProject $project)
    {
        $project->delete();

        return redirect()->route('missions.projects.index')->with('success', 'Projeto missionário removido com sucesso.');
    }
}
