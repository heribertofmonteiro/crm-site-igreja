<?php

namespace App\Http\Controllers;

use App\Models\PastoralCouncil;
use App\Models\PastoralNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PastoralNoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:pastoral_notes.view')->only(['index', 'show']);
        $this->middleware('permission:pastoral_notes.create')->only(['create', 'store']);
        $this->middleware('permission:pastoral_notes.edit')->only(['edit', 'update']);
        $this->middleware('permission:pastoral_notes.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = PastoralNote::with(['council', 'user'])->paginate(10);
        return view('pastoral.notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $councils = PastoralCouncil::all();
        $types = ['vision', 'doctrine', 'teaching', 'counseling', 'report'];
        return view('pastoral.notes.create', compact('councils', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'council_id' => 'required|exists:pastoral_councils,id',
            'type' => 'required|in:vision,doctrine,teaching,counseling,report',
        ]);

        $request->merge(['user_id' => Auth::id()]);

        PastoralNote::create($request->all());

        return redirect()->route('pastoral.notes.index')
            ->with('success', 'Nota Pastoral criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PastoralNote $note)
    {
        return view('pastoral.notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PastoralNote $note)
    {
        $councils = PastoralCouncil::all();
        $types = ['vision', 'doctrine', 'teaching', 'counseling', 'report'];
        return view('pastoral.notes.edit', compact('note', 'councils', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PastoralNote $note)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'council_id' => 'required|exists:pastoral_councils,id',
            'type' => 'required|in:vision,doctrine,teaching,counseling,report',
        ]);

        $note->update($request->all());

        return redirect()->route('pastoral.notes.index')
            ->with('success', 'Nota Pastoral atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PastoralNote $note)
    {
        $note->delete();

        return redirect()->route('pastoral.notes.index')
            ->with('success', 'Nota Pastoral excluída com sucesso.');
    }
}
