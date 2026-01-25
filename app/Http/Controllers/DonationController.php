<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\FinancialAccount;
use App\Mail\DonationConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DonationController extends Controller
{
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

        // Assumir uma conta financeira padrão para doações, ou pegar a primeira
        $financialAccount = FinancialAccount::first();

        if (!$financialAccount) {
            return back()->withErrors(['error' => 'Conta financeira não configurada.']);
        }

        $transaction = Transaction::create([
            'financial_account_id' => $financialAccount->id,
            'type' => 'income',
            'amount' => $request->amount,
            'description' => 'Doação online - ' . $request->donation_type,
            'date' => now()->toDateString(),
            'category' => 'donation',
            'donor_name' => $request->donor_name,
            'donor_email' => $request->donor_email,
            'donation_type' => $request->donation_type,
            'payment_method' => $request->payment_method,
        ]);

        // Enviar email de confirmação
        Mail::to($request->donor_email)->send(new DonationConfirmation($transaction));

        return redirect()->route('donation.create')->with('success', 'Doação registrada com sucesso! Verifique seu email para confirmação.');
    }
}
