<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:documents.view')->only(['index', 'show', 'download']);
        $this->middleware('permission:documents.create')->only(['create', 'store']);
        $this->middleware('permission:documents.edit')->only(['edit', 'update']);
        $this->middleware('permission:documents.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::with('event')->paginate(10);
        return view('admin.documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::all();
        return view('admin.documents.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|max:10240', // 10MB
            'event_id' => 'nullable|exists:events,id',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('documents');
            
            Document::create([
                'title' => $request->title,
                'file_path' => $path,
                'church_event_id' => $request->event_id,
            ]);

            return redirect()->route('admin.documents.index')
                ->with('success', 'Documento enviado com sucesso.');
        }

        return back()->with('error', 'Falha ao enviar arquivo.');
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
        $events = Event::all();
        return view('admin.documents.edit', compact('document', 'events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'event_id' => 'nullable|exists:events,id',
        ]);

        $document->update([
            'title' => $request->title,
            'church_event_id' => $request->event_id,
        ]);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Documento atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        if (Storage::exists($document->file_path)) {
            Storage::delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('admin.documents.index')
            ->with('success', 'Documento removido com sucesso.');
    }

    /**
     * Download the specified resource.
     */
    public function download(Document $document)
    {
        if (Storage::exists($document->file_path)) {
            return Storage::download($document->file_path, $document->title);
        }

        return back()->with('error', 'Arquivo não encontrado.');
    }
}
