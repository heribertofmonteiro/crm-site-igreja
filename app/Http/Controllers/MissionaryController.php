<?php

namespace App\Http\Controllers;

use App\Models\Missionary;
use App\Models\MissionProject;
use App\Models\MissionSupport;
use Illuminate\Http\Request;

class MissionaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $missionaries = Missionary::with('projects')->paginate(10);
        return view('admin.missions.missionaries.index', compact('missionaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.missions.missionaries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:missionaries',
            'phone' => 'nullable|string|max:20',
            'country' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,inactive',
            'bio' => 'nullable|string',
        ]);

        Missionary::create($request->all());

        return redirect()->route('missions.missionaries.index')->with('success', 'Missionário criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Missionary $missionary)
    {
        $missionary->load('projects', 'supports.supporter');
        return view('admin.missions.missionaries.show', compact('missionary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Missionary $missionary)
    {
        return view('admin.missions.missionaries.edit', compact('missionary'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Missionary $missionary)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:missionaries,email,' . $missionary->id,
            'phone' => 'nullable|string|max:20',
            'country' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,inactive',
            'bio' => 'nullable|string',
        ]);

        $missionary->update($request->all());

        return redirect()->route('missions.missionaries.index')->with('success', 'Missionário atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Missionary $missionary)
    {
        $missionary->delete();

        return redirect()->route('missions.missionaries.index')->with('success', 'Missionário removido com sucesso.');
    }
}
