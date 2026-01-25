<?php

namespace App\Http\Controllers;

use App\Models\Doctrine;
use App\Models\User;
use Illuminate\Http\Request;

class DoctrineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:doctrines.view')->only(['index', 'show']);
        $this->middleware('permission:doctrines.create')->only(['create', 'store']);
        $this->middleware('permission:doctrines.edit')->only(['edit', 'update']);
        $this->middleware('permission:doctrines.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctrines = Doctrine::with('author')->paginate(10);
        return view('pastoral.doctrines.index', compact('doctrines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('pastoral.doctrines.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author_id' => 'required|exists:users,id',
        ]);

        Doctrine::create($request->all());

        return redirect()->route('pastoral.doctrines.index')
            ->with('success', 'Doutrina criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctrine $doctrine)
    {
        return view('pastoral.doctrines.show', compact('doctrine'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctrine $doctrine)
    {
        $users = User::all();
        return view('pastoral.doctrines.edit', compact('doctrine', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctrine $doctrine)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author_id' => 'required|exists:users,id',
            'approved_at' => 'nullable|date',
        ]);

        $doctrine->update($request->all());

        return redirect()->route('pastoral.doctrines.index')
            ->with('success', 'Doutrina atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctrine $doctrine)
    {
        $doctrine->delete();

        return redirect()->route('pastoral.doctrines.index')
            ->with('success', 'Doutrina excluída com sucesso.');
    }
}
