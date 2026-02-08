<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:education_classes.view')->only(['index', 'show']);
        $this->middleware('permission:education_classes.create')->only(['create', 'store']);
        $this->middleware('permission:education_classes.edit')->only(['edit', 'update']);
        $this->middleware('permission:education_classes.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = SchoolClass::with('teacher')->paginate(10);
        return view('education.classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = User::all();
        return view('education.classes.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'age_group' => 'required|string|max:255',
            'teacher_id' => 'required|exists:users,id',
        ]);

        SchoolClass::create($request->all());

        return redirect()->route('education.classes.index')
            ->with('success', 'Turma criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolClass $class)
    {
        $class->load('teacher', 'students', 'educationalMaterials');
        return view('education.classes.show', compact('class'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolClass $class)
    {
        $teachers = User::all();
        return view('education.classes.edit', compact('class', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolClass $class)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'age_group' => 'required|string|max:255',
            'teacher_id' => 'required|exists:users,id',
        ]);

        $class->update($request->all());

        return redirect()->route('education.classes.index')
            ->with('success', 'Turma atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolClass $class)
    {
        $class->delete();

        return redirect()->route('education.classes.index')
            ->with('success', 'Turma removida com sucesso.');
    }
}
