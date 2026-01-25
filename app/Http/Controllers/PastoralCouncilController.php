<?php

namespace App\Http\Controllers;

use App\Models\PastoralCouncil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PastoralCouncilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:pastoral_councils.view')->only(['index', 'show']);
        $this->middleware('permission:pastoral_councils.create')->only(['create', 'store']);
        $this->middleware('permission:pastoral_councils.edit')->only(['edit', 'update']);
        $this->middleware('permission:pastoral_councils.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $councils = PastoralCouncil::paginate(10);
        return view('pastoral.councils.index', compact('councils'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('pastoral.councils.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'vision' => 'nullable|string',
            'doctrine_statement' => 'nullable|string',
            'members' => 'nullable|array',
            'members.*' => 'exists:users,id',
        ]);

        PastoralCouncil::create($request->all());

        return redirect()->route('pastoral.councils.index')
            ->with('success', 'Conselho Pastoral criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PastoralCouncil $council)
    {
        return view('pastoral.councils.show', compact('council'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PastoralCouncil $council)
    {
        $users = User::all();
        return view('pastoral.councils.edit', compact('council', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PastoralCouncil $council)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'vision' => 'nullable|string',
            'doctrine_statement' => 'nullable|string',
            'members' => 'nullable|array',
            'members.*' => 'exists:users,id',
        ]);

        $council->update($request->all());

        return redirect()->route('pastoral.councils.index')
            ->with('success', 'Conselho Pastoral atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PastoralCouncil $council)
    {
        $council->delete();

        return redirect()->route('pastoral.councils.index')
            ->with('success', 'Conselho Pastoral excluído com sucesso.');
    }
}
