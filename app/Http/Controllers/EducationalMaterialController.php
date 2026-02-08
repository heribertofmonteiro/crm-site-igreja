<?php

namespace App\Http\Controllers;

use App\Models\EducationalMaterial;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class EducationalMaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:education_materials.view')->only(['index', 'show']);
        $this->middleware('permission:education_materials.create')->only(['create', 'store']);
        $this->middleware('permission:education_materials.edit')->only(['edit', 'update']);
        $this->middleware('permission:education_materials.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = EducationalMaterial::with('schoolClass')->paginate(10);
        return view('education.materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = SchoolClass::all();
        return view('education.materials.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:255',
            'url' => 'nullable|url',
            'class_id' => 'required|exists:classes,id',
        ]);

        EducationalMaterial::create($request->all());

        return redirect()->route('education.materials.index')
            ->with('success', 'Material educacional criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EducationalMaterial $material)
    {
        $material->load('schoolClass');
        return view('education.materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EducationalMaterial $material)
    {
        $classes = SchoolClass::all();
        return view('education.materials.edit', compact('material', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EducationalMaterial $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:255',
            'url' => 'nullable|url',
            'class_id' => 'required|exists:classes,id',
        ]);

        $material->update($request->all());

        return redirect()->route('education.materials.index')
            ->with('success', 'Material educacional atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EducationalMaterial $material)
    {
        $material->delete();

        return redirect()->route('education.materials.index')
            ->with('success', 'Material educacional removido com sucesso.');
    }
}
