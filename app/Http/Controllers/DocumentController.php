<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Member;
use App\Models\ChurchEvent;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:documents.view')->only(['index', 'show']);
        $this->middleware('permission:documents.create')->only(['create', 'store']);
        $this->middleware('permission:documents.edit')->only(['edit', 'update']);
        $this->middleware('permission:documents.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::with(['member', 'churchEvent'])->paginate(10);
        return view('admin.documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = Member::all();
        $events = ChurchEvent::all();
        return view('admin.documents.create', compact('members', 'events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:certificate,report,contract,other',
            'file_path' => 'required|string|max:255',
            'member_id' => 'nullable|exists:members,id',
            'church_event_id' => 'nullable|exists:church_events,id',
        ]);

        Document::create($request->all());

        return redirect()->route('admin.documents.index')
            ->with('success', 'Documento criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        return view('admin.documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        $members = Member::all();
        $events = ChurchEvent::all();
        return view('admin.documents.edit', compact('document', 'members', 'events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:certificate,report,contract,other',
            'file_path' => 'required|string|max:255',
            'member_id' => 'nullable|exists:members,id',
            'church_event_id' => 'nullable|exists:church_events,id',
        ]);

        $document->update($request->all());

        return redirect()->route('admin.documents.index')
            ->with('success', 'Documento atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        $document->delete();

        return redirect()->route('admin.documents.index')
            ->with('success', 'Documento removido com sucesso.');
    }
}
