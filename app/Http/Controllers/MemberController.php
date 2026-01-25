<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:members.view')->only(['index', 'show']);
        $this->middleware('permission:members.create')->only(['create', 'store']);
        $this->middleware('permission:members.edit')->only(['edit', 'update']);
        $this->middleware('permission:members.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::paginate(10);

        // Cache de membros ativos (exemplo: membros não deletados)
        $activeMembersCount = Cache::remember('active_members_count', 3600, function () {
            return Member::whereNull('deleted_at')->count();
        });

        return view('admin.members.index', compact('members', 'activeMembersCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'baptism_date' => 'nullable|date',
            'marital_status' => 'required|in:single,married,divorced,widowed',
        ]);

        Member::create($request->all());

        return redirect()->route('admin.members.index')
            ->with('success', 'Membro criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return view('admin.members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'baptism_date' => 'nullable|date',
            'marital_status' => 'required|in:single,married,divorced,widowed',
        ]);

        $member->update($request->all());

        return redirect()->route('admin.members.index')
            ->with('success', 'Membro atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('admin.members.index')
            ->with('success', 'Membro removido com sucesso.');
    }
}
