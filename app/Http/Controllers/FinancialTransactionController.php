<?php

namespace App\Http\Controllers;

use App\Models\FinancialAccount;
use App\Models\FinancialTransaction;
use App\Models\TransactionCategory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class FinancialTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = FinancialTransaction::with(['account', 'category'])
            ->when($request->account_id, function ($q, $accountId) {
                $q->where('account_id', $accountId);
            })
            ->when($request->category_id, function ($q, $categoryId) {
                $q->where('category_id', $categoryId);
            })
            ->when($request->type, function ($q, $type) {
                $q->where('type', $type);
            })
            ->when($request->status, function ($q, $status) {
                $q->where('status', $status);
            })
            ->when($request->date_from, function ($q, $date) {
                $q->whereDate('transaction_date', '>=', $date);
            })
            ->when($request->date_to, function ($q, $date) {
                $q->whereDate('transaction_date', '<=', $date);
            })
            ->when($request->search, function ($q, $search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('description', 'like', "%{$search}%")
                          ->orWhere('reference', 'like', "%{$search}%");
                });
            })
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc');

        $transactions = $query->paginate(15);
        $accounts = FinancialAccount::orderBy('name')->get();
        $categories = TransactionCategory::active()->orderBy('name')->get();

        return view('admin.finance.transactions.index', compact('transactions', 'accounts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $accounts = FinancialAccount::orderBy('name')->get();
        $incomeCategories = TransactionCategory::active()->where('type', 'income')->orderBy('name')->get();
        $expenseCategories = TransactionCategory::active()->where('type', 'expense')->orderBy('name')->get();

        return view('admin.finance.transactions.create', compact('accounts', 'incomeCategories', 'expenseCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:financial_accounts,id',
            'category_id' => 'required|exists:transaction_categories,id',
            'type' => 'required|string|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:500',
            'reference' => 'nullable|string|max:100',
            'status' => 'nullable|string|in:pending,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        FinancialTransaction::create($validated);

        return redirect()
            ->route('admin.finance.transactions.index')
            ->with('success', 'Transação registrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(FinancialTransaction $transaction): View
    {
        return view('admin.finance.transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinancialTransaction $transaction): View
    {
        $accounts = FinancialAccount::orderBy('name')->get();
        $incomeCategories = TransactionCategory::active()->where('type', 'income')->orderBy('name')->get();
        $expenseCategories = TransactionCategory::active()->where('type', 'expense')->orderBy('name')->get();

        return view('admin.finance.transactions.edit', compact('transaction', 'accounts', 'incomeCategories', 'expenseCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FinancialTransaction $transaction): RedirectResponse
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:financial_accounts,id',
            'category_id' => 'required|exists:transaction_categories,id',
            'type' => 'required|string|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:500',
            'reference' => 'nullable|string|max:100',
            'status' => 'nullable|string|in:pending,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $transaction->update($validated);

        return redirect()
            ->route('admin.finance.transactions.index')
            ->with('success', 'Transação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinancialTransaction $transaction): RedirectResponse
    {
        $transaction->delete();

        return redirect()
            ->route('admin.finance.transactions.index')
            ->with('success', 'Transação excluída com sucesso!');
    }

    /**
     * Reconcile transaction.
     */
    public function reconcile(FinancialTransaction $transaction): RedirectResponse
    {
        $transaction->update(['status' => 'completed']);

        return redirect()
            ->route('admin.finance.transactions.index')
            ->with('success', 'Transação conciliada!');
    }

    /**
     * Unreconcile transaction.
     */
    public function unreconcile(FinancialTransaction $transaction): RedirectResponse
    {
        $transaction->update(['status' => 'pending']);

        return redirect()
            ->route('admin.finance.transactions.index')
            ->with('success', 'Transação descompletada!');
    }

    /**
     * Update status.
     */
    public function updateStatus(Request $request, FinancialTransaction $transaction): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,completed,cancelled',
        ]);

        $transaction->update($validated);

        return redirect()
            ->route('admin.finance.transactions.index')
            ->with('success', 'Status atualizado!');
    }
}
