<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:education_students.view')->only(['index', 'show']);
        $this->middleware('permission:education_students.create')->only(['create', 'store']);
        $this->middleware('permission:education_students.edit')->only(['edit', 'update']);
        $this->middleware('permission:education_students.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('schoolClass', 'parent')->paginate(10);
        return view('education.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = SchoolClass::all();
        $members = Member::all();
        return view('education.students.create', compact('classes', 'members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'contact_info' => 'nullable|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'parent_id' => 'nullable|exists:members,id',
        ]);

        Student::create($request->all());

        return redirect()->route('education.students.index')
            ->with('success', 'Estudante criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student->load('schoolClass', 'parent');
        return view('education.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $classes = SchoolClass::all();
        $members = Member::all();
        return view('education.students.edit', compact('student', 'classes', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'contact_info' => 'nullable|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'parent_id' => 'nullable|exists:members,id',
        ]);

        $student->update($request->all());

        return redirect()->route('education.students.index')
            ->with('success', 'Estudante atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('education.students.index')
            ->with('success', 'Estudante removido com sucesso.');
    }
}
