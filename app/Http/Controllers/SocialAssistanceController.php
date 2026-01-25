<?php

namespace App\Http\Controllers;

use App\Models\SocialAssistance;
use Illuminate\Http\Request;

class SocialAssistanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:social_assistance.view')->only(['index', 'show']);
        $this->middleware('permission:social_assistance.create')->only(['create', 'store']);
        $this->middleware('permission:social_assistance.edit')->only(['edit', 'update']);
        $this->middleware('permission:social_assistance.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assistances = SocialAssistance::with('socialProject')->paginate(10);

        return view('admin.social.assistances.index', compact('assistances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = \App\Models\SocialProject::all();
        return view('admin.social.assistances.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'social_project_id' => 'required|exists:social_projects,id',
            'beneficiary_name' => 'required|string|max:255',
            'beneficiary_contact' => 'nullable|string|max:255',
            'assistance_type' => 'required|in:food,clothing,medical,financial,other',
            'description' => 'nullable|string',
            'date_provided' => 'required|date',
            'amount' => 'nullable|numeric|min:0',
        ]);

        SocialAssistance::create($request->all());

        return redirect()->route('social.assistances.index')
            ->with('success', 'Assistência criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SocialAssistance $assistance)
    {
        return view('admin.social.assistances.show', compact('assistance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocialAssistance $assistance)
    {
        $projects = \App\Models\SocialProject::all();
        return view('admin.social.assistances.edit', compact('assistance', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SocialAssistance $assistance)
    {
        $request->validate([
            'social_project_id' => 'required|exists:social_projects,id',
            'beneficiary_name' => 'required|string|max:255',
            'beneficiary_contact' => 'nullable|string|max:255',
            'assistance_type' => 'required|in:food,clothing,medical,financial,other',
            'description' => 'nullable|string',
            'date_provided' => 'required|date',
            'amount' => 'nullable|numeric|min:0',
        ]);

        $assistance->update($request->all());

        return redirect()->route('social.assistances.index')
            ->with('success', 'Assistência atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialAssistance $assistance)
    {
        $assistance->delete();

        return redirect()->route('social.assistances.index')
            ->with('success', 'Assistência removida com sucesso.');
    }
}