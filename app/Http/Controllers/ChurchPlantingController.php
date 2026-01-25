<?php

namespace App\Http\Controllers;

use App\Models\ChurchPlantingPlan;
use App\Models\User;
use Illuminate\Http\Request;

class ChurchPlantingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = ChurchPlantingPlan::with('leader')->paginate(10);
        return view('admin.church_planting_plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $leaders = User::all();
        return view('admin.church_planting_plans.create', compact('leaders'));
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
            'planned_start_date' => 'required|date',
            'planned_end_date' => 'nullable|date|after:planned_start_date',
            'status' => 'required|in:planned,in_progress,completed',
            'budget' => 'nullable|numeric|min:0',
            'leader_id' => 'nullable|exists:users,id',
        ]);

        ChurchPlantingPlan::create($request->all());

        return redirect()->route('expansion.church-planting-plans.index')->with('success', 'Plano de plantação criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $plan = ChurchPlantingPlan::with('leader')->findOrFail($id);
        return view('admin.church_planting_plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $plan = ChurchPlantingPlan::findOrFail($id);
        $leaders = User::all();
        return view('admin.church_planting_plans.edit', compact('plan', 'leaders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'planned_start_date' => 'required|date',
            'planned_end_date' => 'nullable|date|after:planned_start_date',
            'status' => 'required|in:planned,in_progress,completed',
            'budget' => 'nullable|numeric|min:0',
            'leader_id' => 'nullable|exists:users,id',
        ]);

        $plan = ChurchPlantingPlan::findOrFail($id);
        $plan->update($request->all());

        return redirect()->route('expansion.church-planting-plans.index')->with('success', 'Plano de plantação atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plan = ChurchPlantingPlan::findOrFail($id);
        $plan->delete();

        return redirect()->route('expansion.church-planting-plans.index')->with('success', 'Plano de plantação excluído com sucesso.');
    }
}
