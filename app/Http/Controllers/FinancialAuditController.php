<?php

namespace App\Http\Controllers;

use App\Models\FinancialAudit;
use Illuminate\Http\Request;

class FinancialAuditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $audits = FinancialAudit::orderBy('audit_date', 'desc')->paginate(10);
        return view('finance.financial_audits.index', compact('audits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('finance.financial_audits.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'audit_date' => 'required|date',
            'period_start' => 'required|date',
            'period_end' => 'required|date',
            'findings' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'auditor' => 'nullable|string',
        ]);

        FinancialAudit::create($request->all());

        return redirect()->route('financial-audits.index')->with('success', 'Auditoria criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FinancialAudit $financialAudit)
    {
        return view('finance.financial_audits.show', compact('financialAudit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinancialAudit $financialAudit)
    {
        return view('finance.financial_audits.edit', compact('financialAudit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FinancialAudit $financialAudit)
    {
        $request->validate([
            'audit_date' => 'required|date',
            'period_start' => 'required|date',
            'period_end' => 'required|date',
            'findings' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'auditor' => 'nullable|string',
        ]);

        $financialAudit->update($request->all());

        return redirect()->route('financial-audits.index')->with('success', 'Auditoria atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinancialAudit $financialAudit)
    {
        $financialAudit->delete();

        return redirect()->route('financial-audits.index')->with('success', 'Auditoria excluída com sucesso.');
    }

    /**
     * Generate report for a specific audit.
     */
    public function report(FinancialAudit $financialAudit)
    {
        return view('finance.financial_audits.report', compact('financialAudit'));
    }
}
