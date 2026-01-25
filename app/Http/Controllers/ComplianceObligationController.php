<?php

namespace App\Http\Controllers;

use App\Models\ComplianceObligation;
use Illuminate\Http\Request;

class ComplianceObligationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:compliance_obligations.view')->only(['index', 'show']);
        $this->middleware('permission:compliance_obligations.create')->only(['create', 'store']);
        $this->middleware('permission:compliance_obligations.edit')->only(['edit', 'update']);
        $this->middleware('permission:compliance_obligations.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $complianceObligations = ComplianceObligation::with('responsibleUser')->paginate(10);

        return view('admin.legal.compliance_obligations.index', compact('complianceObligations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.legal.compliance_obligations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'obligation_type' => 'required|in:tax,legal,regulatory,financial,other',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,completed,overdue,cancelled',
            'responsible_user_id' => 'required|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        ComplianceObligation::create($request->all());

        return redirect()->route('admin.legal.compliance_obligations.index')
            ->with('success', 'Obrigação de conformidade criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ComplianceObligation $complianceObligation)
    {
        return view('admin.legal.compliance_obligations.show', compact('complianceObligation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComplianceObligation $complianceObligation)
    {
        return view('admin.legal.compliance_obligations.edit', compact('complianceObligation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ComplianceObligation $complianceObligation)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'obligation_type' => 'required|in:tax,legal,regulatory,financial,other',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,completed,overdue,cancelled',
            'responsible_user_id' => 'required|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        $complianceObligation->update($request->all());

        return redirect()->route('admin.legal.compliance_obligations.index')
            ->with('success', 'Obrigação de conformidade atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComplianceObligation $complianceObligation)
    {
        $complianceObligation->delete();

        return redirect()->route('admin.legal.compliance_obligations.index')
            ->with('success', 'Obrigação de conformidade removida com sucesso.');
    }
}
