<?php

namespace App\Http\Controllers;

use App\Models\SocialVolunteer;
use Illuminate\Http\Request;

class SocialVolunteerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:social_volunteer.view')->only(['index', 'show']);
        $this->middleware('permission:social_volunteer.create')->only(['create', 'store']);
        $this->middleware('permission:social_volunteer.edit')->only(['edit', 'update']);
        $this->middleware('permission:social_volunteer.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $volunteers = SocialVolunteer::with(['socialProject', 'user'])->paginate(10);

        return view('admin.social.volunteers.index', compact('volunteers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = \App\Models\SocialProject::all();
        $users = \App\Models\User::all();
        return view('admin.social.volunteers.create', compact('projects', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'social_project_id' => 'required|exists:social_projects,id',
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|max:255',
            'joined_at' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        SocialVolunteer::create($request->all());

        return redirect()->route('social.volunteers.index')
            ->with('success', 'Voluntário adicionado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SocialVolunteer $volunteer)
    {
        return view('admin.social.volunteers.show', compact('volunteer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocialVolunteer $volunteer)
    {
        $projects = \App\Models\SocialProject::all();
        $users = \App\Models\User::all();
        return view('admin.social.volunteers.edit', compact('volunteer', 'projects', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SocialVolunteer $volunteer)
    {
        $request->validate([
            'social_project_id' => 'required|exists:social_projects,id',
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|max:255',
            'joined_at' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        $volunteer->update($request->all());

        return redirect()->route('social.volunteers.index')
            ->with('success', 'Voluntário atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialVolunteer $volunteer)
    {
        $volunteer->delete();

        return redirect()->route('social.volunteers.index')
            ->with('success', 'Voluntário removido com sucesso.');
    }
}