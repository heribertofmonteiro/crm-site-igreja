<?php

namespace App\Http\Controllers;

use App\Models\VolunteerRole;
use Illuminate\Http\Request;

class VolunteerRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:volunteer_roles.view')->only(['index', 'show']);
        $this->middleware('permission:volunteer_roles.create')->only(['create', 'store']);
        $this->middleware('permission:volunteer_roles.edit')->only(['edit', 'update']);
        $this->middleware('permission:volunteer_roles.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $volunteerRoles = VolunteerRole::paginate(10);

        return view('admin.volunteer_roles.index', compact('volunteerRoles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.volunteer_roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        VolunteerRole::create($request->all());

        return redirect()->route('admin.volunteer_roles.index')
            ->with('success', 'Função de voluntário criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(VolunteerRole $volunteerRole)
    {
        return view('admin.volunteer_roles.show', compact('volunteerRole'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VolunteerRole $volunteerRole)
    {
        return view('admin.volunteer_roles.edit', compact('volunteerRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VolunteerRole $volunteerRole)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $volunteerRole->update($request->all());

        return redirect()->route('admin.volunteer_roles.index')
            ->with('success', 'Função de voluntário atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VolunteerRole $volunteerRole)
    {
        $volunteerRole->delete();

        return redirect()->route('admin.volunteer_roles.index')
            ->with('success', 'Função de voluntário removida com sucesso.');
    }
}