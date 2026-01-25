<?php

namespace App\Http\Controllers;

use App\Models\LgpdConsent;
use Illuminate\Http\Request;

class LgpdConsentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:lgpd_consents.view')->only(['index', 'show']);
        $this->middleware('permission:lgpd_consents.create')->only(['create', 'store']);
        $this->middleware('permission:lgpd_consents.edit')->only(['edit', 'update']);
        $this->middleware('permission:lgpd_consents.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lgpdConsents = LgpdConsent::with('member')->paginate(10);

        return view('admin.legal.lgpd_consents.index', compact('lgpdConsents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.legal.lgpd_consents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'consent_type' => 'required|in:data_processing,marketing,communication,other',
            'consent_given' => 'required|boolean',
            'consent_date' => 'required|date',
            'ip_address' => 'nullable|ip',
            'user_agent' => 'nullable|string',
        ]);

        LgpdConsent::create($request->all());

        return redirect()->route('admin.legal.lgpd_consents.index')
            ->with('success', 'Consentimento LGPD criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LgpdConsent $lgpdConsent)
    {
        return view('admin.legal.lgpd_consents.show', compact('lgpdConsent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LgpdConsent $lgpdConsent)
    {
        return view('admin.legal.lgpd_consents.edit', compact('lgpdConsent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LgpdConsent $lgpdConsent)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'consent_type' => 'required|in:data_processing,marketing,communication,other',
            'consent_given' => 'required|boolean',
            'consent_date' => 'required|date',
            'ip_address' => 'nullable|ip',
            'user_agent' => 'nullable|string',
        ]);

        $lgpdConsent->update($request->all());

        return redirect()->route('admin.legal.lgpd_consents.index')
            ->with('success', 'Consentimento LGPD atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LgpdConsent $lgpdConsent)
    {
        $lgpdConsent->delete();

        return redirect()->route('admin.legal.lgpd_consents.index')
            ->with('success', 'Consentimento LGPD removido com sucesso.');
    }
}
