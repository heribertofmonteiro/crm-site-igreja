<?php

namespace App\Http\Controllers;

use App\Models\FinancialTransaction;
use App\Models\FinancialAccount;
use App\Models\TransactionCategory;
use App\Mail\DonationConfirmation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class DonationController extends Controller
{
    /**
     * Display a listing of donations.
     */
    public function index(): View
    {
        // Assumindo que temos uma categoria 'Doação' ou 'Receita'
        $donations = FinancialTransaction::income()
            ->whereJsonContains('metadata->is_donation', true)
            ->paginate(10);
            
        return view('admin.donations.index', compact('donations'));
    }

    public function create()
    {
        return view('public.donation.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'amount' => 'required|numeric|min:0.01',
            'donation_type' => 'required|in:dízimo,oferta',
            'payment_method' => 'required|string|max:255',
        ]);

        $financialAccount = FinancialAccount::first();
        if (!$financialAccount) {
            return back()->withErrors(['error' => 'Conta financeira não configurada.']);
        }

        // Tentar encontrar ou criar categoria de doação
        $category = TransactionCategory::where('name', 'Doação')->first() 
                    ?? TransactionCategory::where('type', 'income')->first();

        $transaction = FinancialTransaction::create([
            'account_id' => $financialAccount->id,
            'type' => 'income',
            'amount' => $request->amount,
            'description' => 'Doação online - ' . $request->donation_type,
            'transaction_date' => now(),
            'category_id' => $category ? $category->id : 1,
            'created_by' => auth()->id() ?? 1, // Fallback para sistema
            'metadata' => [
                'is_donation' => true,
                'donor_name' => $request->donor_name,
                'donor_email' => $request->donor_email,
                'donation_type' => $request->donation_type,
                'payment_method' => $request->payment_method,
            ]
        ]);

        Mail::to($request->donor_email)->send(new DonationConfirmation($transaction));

        return redirect()->route('donation.create')->with('success', 'Doação registrada com sucesso!');
    }

    public function show(FinancialTransaction $donation): View
    {
        return view('admin.donations.show', compact('donation'));
    }

    public function edit(FinancialTransaction $donation): View
    {
        return view('admin.donations.edit', compact('donation'));
    }

    public function update(Request $request, FinancialTransaction $donation): RedirectResponse
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'amount' => 'required|numeric|min:0.01',
            'donation_type' => 'required|in:dízimo,oferta',
            'payment_method' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $metadata = $donation->metadata ?? [];
        $metadata = array_merge($metadata, [
            'donor_name' => $validated['donor_name'],
            'donor_email' => $validated['donor_email'],
            'donation_type' => $validated['donation_type'],
            'payment_method' => $validated['payment_method'],
        ]);

        $donation->update([
            'amount' => $validated['amount'],
            'description' => $validated['description'] ?? $donation->description,
            'metadata' => $metadata
        ]);

        return redirect()->route('admin.donations.index')->with('success', 'Doação atualizada com sucesso.');
    }

    public function destroy(FinancialTransaction $donation): RedirectResponse
    {
        $donation->delete();
        return redirect()->route('admin.donations.index')->with('success', 'Doação excluída com sucesso.');
    }
}
