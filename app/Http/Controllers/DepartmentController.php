<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    public function index(): View
    {
        $departments = Department::with(['responsible', 'documents', 'announcements', 'meetingMinutes'])
            ->withCount(['documents', 'announcements', 'meetingMinutes'])
            ->active()
            ->latest()
            ->paginate(15);
        
        return view('admin.administration.departments.index', compact('departments'));
    }

    public function create(): View
    {
        return view('admin.administration.departments.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
            'responsible_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
        ]);

        Department::create([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color ?? '#6c757d',
            'icon' => $request->icon,
            'responsible_id' => $request->responsible_id,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('admin.administration.departments.index')
            ->with('success', 'Departamento criado com sucesso!');
    }

    public function show(Department $department): View
    {
        $department->load([
            'responsible',
            'documents' => function ($query) {
                $query->latest()->limit(10);
            },
            'announcements' => function ($query) {
                $query->active()->latest()->limit(5);
            },
            'meetingMinutes' => function ($query) {
                $query->active()->latest('meeting_date')->limit(5);
            }
        ]);
        
        return view('admin.administration.departments.show', compact('department'));
    }

    public function edit(Department $department): View
    {
        return view('admin.administration.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
            'responsible_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
        ]);

        $department->update([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color ?? '#6c757d',
            'icon' => $request->icon,
            'responsible_id' => $request->responsible_id,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.administration.departments.index')
            ->with('success', 'Departamento atualizado com sucesso!');
    }

    public function destroy(Department $department): RedirectResponse
    {
        if ($department->documents()->exists() || 
            $department->announcements()->exists() || 
            $department->meetingMinutes()->exists()) {
            return back()->withErrors(['error' => 'Não é possível excluir um departamento com documentos, comunicados ou atas.']);
        }

        $department->delete();

        return redirect()
            ->route('admin.administration.departments.index')
            ->with('success', 'Departamento excluído com sucesso!');
    }
}
