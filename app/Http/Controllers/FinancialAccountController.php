<?php

namespace App\Http\Controllers;

use App\Models\FinancialAccount;
use Illuminate\Http\Request;

class FinancialAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:financial_accounts.view')->only(['index', 'show']);
        $this->middleware('permission:financial_accounts.create')->only(['create', 'store']);
        $this->middleware('permission:financial_accounts.edit')->only(['edit', 'update']);
        $this->middleware('permission:financial_accounts.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $financialAccounts = FinancialAccount::paginate(10);
        return view('finance.financial_accounts.index', compact('financialAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('finance.financial_accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:checking,savings,investment',
            'balance' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        FinancialAccount::create($request->all());

        return redirect()->route('finance.financial_accounts.index')
            ->with('success', 'Conta financeira criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FinancialAccount $financialAccount)
    {
        return view('finance.financial_accounts.show', compact('financialAccount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinancialAccount $financialAccount)
    {
        return view('finance.financial_accounts.edit', compact('financialAccount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FinancialAccount $financialAccount)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:checking,savings,investment',
            'balance' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $financialAccount->update($request->all());

        return redirect()->route('finance.financial_accounts.index')
            ->with('success', 'Conta financeira atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinancialAccount $financialAccount)
    {
        $financialAccount->delete();

        return redirect()->route('finance.financial_accounts.index')
            ->with('success', 'Conta financeira removida com sucesso.');
    }
}
