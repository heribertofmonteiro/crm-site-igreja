<?php

namespace App\Http\Controllers;

use App\Models\LegalDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LegalDocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:legal_documents.view')->only(['index', 'show']);
        $this->middleware('permission:legal_documents.create')->only(['create', 'store']);
        $this->middleware('permission:legal_documents.edit')->only(['edit', 'update']);
        $this->middleware('permission:legal_documents.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $legalDocuments = LegalDocument::with('creator')->paginate(10);

        return view('admin.legal.legal_documents.index', compact('legalDocuments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.legal.legal_documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_type' => 'required|in:statute,contract,certificate,license,other',
            'file_path' => 'nullable|string',
            'expiration_date' => 'nullable|date',
            'status' => 'required|in:active,expired,pending,archived',
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::id();

        LegalDocument::create($data);

        return redirect()->route('admin.legal.legal_documents.index')
            ->with('success', 'Documento legal criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LegalDocument $legalDocument)
    {
        return view('admin.legal.legal_documents.show', compact('legalDocument'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LegalDocument $legalDocument)
    {
        return view('admin.legal.legal_documents.edit', compact('legalDocument'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LegalDocument $legalDocument)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_type' => 'required|in:statute,contract,certificate,license,other',
            'file_path' => 'nullable|string',
            'expiration_date' => 'nullable|date',
            'status' => 'required|in:active,expired,pending,archived',
        ]);

        $legalDocument->update($request->all());

        return redirect()->route('admin.legal.legal_documents.index')
            ->with('success', 'Documento legal atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LegalDocument $legalDocument)
    {
        $legalDocument->delete();

        return redirect()->route('admin.legal.legal_documents.index')
            ->with('success', 'Documento legal removido com sucesso.');
    }
}
