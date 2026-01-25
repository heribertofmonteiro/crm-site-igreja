<?php

namespace App\Http\Controllers;

use App\Models\MissionSupport;
use App\Models\Missionary;
use App\Models\Member;
use Illuminate\Http\Request;

class MissionSupportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supports = MissionSupport::with('missionary', 'supporter')->paginate(10);
        return view('admin.missions.supports.index', compact('supports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $missionaries = Missionary::all();
        $members = Member::all();
        return view('admin.missions.supports.create', compact('missionaries', 'members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'missionary_id' => 'required|exists:missionaries,id',
            'supporter_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:0',
            'frequency' => 'required|in:monthly,yearly,one_time',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,inactive',
        ]);

        MissionSupport::create($request->all());

        return redirect()->route('missions.supports.index')->with('success', 'Suporte missionário criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MissionSupport $support)
    {
        $support->load('missionary', 'supporter');
        return view('admin.missions.supports.show', compact('support'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MissionSupport $support)
    {
        $missionaries = Missionary::all();
        $members = Member::all();
        return view('admin.missions.supports.edit', compact('support', 'missionaries', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MissionSupport $support)
    {
        $request->validate([
            'missionary_id' => 'required|exists:missionaries,id',
            'supporter_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:0',
            'frequency' => 'required|in:monthly,yearly,one_time',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,inactive',
        ]);

        $support->update($request->all());

        return redirect()->route('missions.supports.index')->with('success', 'Suporte missionário atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MissionSupport $support)
    {
        $support->delete();

        return redirect()->route('missions.supports.index')->with('success', 'Suporte missionário removido com sucesso.');
    }
}
