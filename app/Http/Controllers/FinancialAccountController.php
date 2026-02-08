<?php

namespace App\Http\Controllers;

use App\Models\FinancialAccount;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FinancialAccountController extends Controller
{
    public function index(): View
    {
        $accounts = FinancialAccount::with(['responsible', 'transactions' => function ($query) {
            $query->latest()->limit(5);
        }])
        ->withCount('transactions')
        ->active()
        ->latest()
        ->paginate(15);
        
        return view('admin.finance.accounts.index', compact('accounts'));
    }

    public function create(): View
    {
        return view('admin.finance.accounts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'account_type' => 'required|in:checking,savings,investment,credit_card',
            'bank_name' => 'nullable|string|max:255',
            'agency_number' => 'nullable|string|max:50',
            'account_number' => 'nullable|string|max:50',
            'opening_balance' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'responsible_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        FinancialAccount::create([
            'name' => $request->name,
            'account_type' => $request->account_type,
            'bank_name' => $request->bank_name,
            'agency_number' => $request->agency_number,
            'account_number' => $request->account_number,
            'opening_balance' => $request->opening_balance,
            'current_balance' => $request->opening_balance,
            'currency' => $request->currency,
            'responsible_id' => $request->responsible_id,
            'is_active' => $request->boolean('is_active', true),
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('admin.finance.accounts.index')
            ->with('success', 'Conta financeira criada com sucesso!');
    }

    public function show(FinancialAccount $account): View
    {
        $account->load(['responsible', 'transactions' => function ($query) {
            $query->with(['category', 'creator'])->latest()->limit(20);
        }]);
        
        return view('admin.finance.accounts.show', compact('account'));
    }

    public function edit(FinancialAccount $account): View
    {
        return view('admin.finance.accounts.edit', compact('account'));
    }

    public function update(Request $request, FinancialAccount $account): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'account_type' => 'required|in:checking,savings,investment,credit_card',
            'bank_name' => 'nullable|string|max:255',
            'agency_number' => 'nullable|string|max:50',
            'account_number' => 'nullable|string|max:50',
            'currency' => 'required|string|max:3',
            'responsible_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $account->update([
            'name' => $request->name,
            'account_type' => $request->account_type,
            'bank_name' => $request->bank_name,
            'agency_number' => $request->agency_number,
            'account_number' => $request->account_number,
            'currency' => $request->currency,
            'responsible_id' => $request->responsible_id,
            'is_active' => $request->boolean('is_active'),
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('admin.finance.accounts.index')
            ->with('success', 'Conta financeira atualizada com sucesso!');
    }

    public function destroy(FinancialAccount $account): RedirectResponse
    {
        if (!$account->canBeDeleted()) {
            return back()->withErrors(['error' => 'Não é possível excluir uma conta com transações.']);
        }

        $account->delete();

        return redirect()
            ->route('admin.finance.accounts.index')
            ->with('success', 'Conta financeira excluída com sucesso!');
    }

    public function updateBalance(FinancialAccount $account): RedirectResponse
    {
        $account->updateBalance();
        
        return back()->with('success', 'Saldo atualizado com sucesso!');
    }

    public function toggleStatus(FinancialAccount $account): RedirectResponse
    {
        $account->update(['is_active' => !$account->is_active]);
        
        return back()->with('success', 'Status da conta atualizado!');
    }
}
