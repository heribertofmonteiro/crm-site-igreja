<?php

namespace App\Http\Controllers;

use App\Models\InstitutionalDocument;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InstitutionalDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = InstitutionalDocument::query()
            ->when($request->search, function ($q, $search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->document_type, function ($q, $type) {
                $q->where('document_type', $type);
            })
            ->when($request->status, function ($q, $status) {
                $q->where('status', $status);
            })
            ->when($request->date_from, function ($q, $date) {
                $q->whereDate('approved_at', '>=', $date);
            })
            ->when($request->date_to, function ($q, $date) {
                $q->whereDate('approved_at', '<=', $date);
            })
            ->orderBy('document_type')
            ->orderBy('title');

        $documents = $query->paginate(15);

        return view('admin.administration.documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.administration.documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_type' => 'required|string|in:statute,regulation,policy,certificate,license,other',
            'version' => 'nullable|string|max:50',
            'content' => 'nullable|string',
            'file_path' => 'nullable|string|max:500',
            'status' => 'nullable|string|in:draft,active,archived,expired',
            'effective_date' => 'nullable|date',
            'expiration_date' => 'nullable|date|after:effective_date',
            'approved_by' => 'nullable|string|max:255',
            'approved_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        InstitutionalDocument::create($validated);

        return redirect()
            ->route('admin.administration.documents.index')
            ->with('success', 'Documento cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(InstitutionalDocument $document): View
    {
        return view('admin.administration.documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InstitutionalDocument $document): View
    {
        return view('admin.administration.documents.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InstitutionalDocument $document): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_type' => 'required|string|in:statute,regulation,policy,certificate,license,other',
            'version' => 'nullable|string|max:50',
            'content' => 'nullable|string',
            'file_path' => 'nullable|string|max:500',
            'status' => 'nullable|string|in:draft,active,archived,expired',
            'effective_date' => 'nullable|date',
            'expiration_date' => 'nullable|date|after:effective_date',
            'approved_by' => 'nullable|string|max:255',
            'approved_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $document->update($validated);

        return redirect()
            ->route('admin.administration.documents.index')
            ->with('success', 'Documento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InstitutionalDocument $document): RedirectResponse
    {
        $document->delete();

        return redirect()
            ->route('admin.administration.documents.index')
            ->with('success', 'Documento excluído com sucesso!');
    }

    /**
     * Activate document.
     */
    public function activate(InstitutionalDocument $document): RedirectResponse
    {
        $document->update([
            'status' => 'active',
            'effective_date' => now(),
            'approved_by' => auth()->user()?->name ?? 'Sistema',
            'approved_at' => now(),
        ]);

        return redirect()
            ->route('admin.administration.documents.index')
            ->with('success', 'Documento ativado!');
    }

    /**
     * Archive document.
     */
    public function archive(InstitutionalDocument $document): RedirectResponse
    {
        $document->update(['status' => 'archived']);

        return redirect()
            ->route('admin.administration.documents.index')
            ->with('success', 'Documento arquivado!');
    }

    /**
     * Expire document.
     */
    public function expire(InstitutionalDocument $document): RedirectResponse
    {
        $document->update([
            'status' => 'expired',
            'expiration_date' => now(),
        ]);

        return redirect()
            ->route('admin.administration.documents.index')
            ->with('success', 'Documento expirado!');
    }

    /**
     * Restore document from archive.
     */
    public function restore(InstitutionalDocument $document): RedirectResponse
    {
        $document->update(['status' => 'active']);

        return redirect()
            ->route('admin.administration.documents.index')
            ->with('success', 'Documento restaurado!');
    }
}
