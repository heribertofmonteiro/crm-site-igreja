<?php

namespace App\Http\Controllers;

use App\Models\SecurityIncident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityIncidentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:security_incidents.view')->only(['index', 'show']);
        $this->middleware('permission:security_incidents.create')->only(['create', 'store']);
        $this->middleware('permission:security_incidents.edit')->only(['edit', 'update']);
        $this->middleware('permission:security_incidents.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incidents = SecurityIncident::with('reportedBy')->paginate(10);

        return view('admin.it.security.index', compact('incidents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.it.security.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'severity' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:open,investigating,resolved,closed',
        ]);

        SecurityIncident::create([
            'title' => $request->title,
            'description' => $request->description,
            'severity' => $request->severity,
            'status' => $request->status,
            'reported_by' => Auth::id(),
            'reported_at' => now(),
            'resolved_at' => $request->status === 'resolved' ? now() : null,
        ]);

        return redirect()->route('it.security.index')
            ->with('success', 'Incidente de segurança reportado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SecurityIncident $incident)
    {
        return view('admin.it.security.show', compact('incident'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SecurityIncident $incident)
    {
        return view('admin.it.security.edit', compact('incident'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SecurityIncident $incident)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'severity' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:open,investigating,resolved,closed',
        ]);

        $incident->update([
            'title' => $request->title,
            'description' => $request->description,
            'severity' => $request->severity,
            'status' => $request->status,
            'resolved_at' => in_array($request->status, ['resolved', 'closed']) ? now() : null,
        ]);

        return redirect()->route('it.security.index')
            ->with('success', 'Incidente de segurança atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SecurityIncident $incident)
    {
        $incident->delete();

        return redirect()->route('it.security.index')
            ->with('success', 'Incidente de segurança removido com sucesso.');
    }
}