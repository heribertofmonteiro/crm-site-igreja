<?php

namespace App\Http\Controllers;

use App\Models\FinancialAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:transactions.view')->only(['index', 'show']);
        $this->middleware('permission:transactions.create')->only(['create', 'store']);
        $this->middleware('permission:transactions.edit')->only(['edit', 'update']);
        $this->middleware('permission:transactions.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with('financialAccount')->paginate(10);
        return view('finance.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $financialAccounts = FinancialAccount::all();
        return view('finance.transactions.create', compact('financialAccounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'financial_account_id' => 'required|exists:financial_accounts,id',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'date' => 'required|date',
            'category' => 'nullable|string|max:255',
        ]);

        Transaction::create($request->all());

        return redirect()->route('finance.transactions.index')
            ->with('success', 'Transação criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return view('finance.transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $financialAccounts = FinancialAccount::all();
        return view('finance.transactions.edit', compact('transaction', 'financialAccounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'financial_account_id' => 'required|exists:financial_accounts,id',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'date' => 'required|date',
            'category' => 'nullable|string|max:255',
        ]);

        $transaction->update($request->all());

        return redirect()->route('finance.transactions.index')
            ->with('success', 'Transação atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('finance.transactions.index')
            ->with('success', 'Transação removida com sucesso.');
    }
}
