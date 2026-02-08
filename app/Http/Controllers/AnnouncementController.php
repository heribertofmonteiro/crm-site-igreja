<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(Request $request): View
    {
        $query = Announcement::with(['department', 'author'])
            ->when($request->search, function ($q, $search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            })
            ->when($request->type, function ($q, $type) {
                $q->where('type', $type);
            })
            ->when($request->priority, function ($q, $priority) {
                $q->where('priority', $priority);
            })
            ->when($request->department_id, function ($q, $departmentId) {
                $q->where('department_id', $departmentId);
            })
            ->latest('published_at');

        $announcements = $query->paginate(15);
        $departments = Department::active()->orderBy('name')->get();
        
        return view('admin.administration.announcements.index', compact('announcements', 'departments'));
    }

    public function create(): View
    {
        $departments = Department::active()->orderBy('name')->get();
        return view('admin.administration.announcements.create', compact('departments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,urgent,event,meeting',
            'priority' => 'required|in:low,normal,high,urgent',
            'department_id' => 'nullable|exists:departments,id',
            'is_active' => 'boolean',
            'published_at' => 'required|date',
            'expires_at' => 'nullable|date|after:published_at',
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'priority' => $request->priority,
            'department_id' => $request->department_id,
            'author_id' => auth()->id(),
            'is_active' => $request->boolean('is_active', true),
            'published_at' => $request->published_at,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()
            ->route('admin.administration.announcements.index')
            ->with('success', 'Comunicado criado com sucesso!');
    }

    public function show(Announcement $announcement): View
    {
        $announcement->incrementViews();
        $announcement->load(['department', 'author']);
        
        return view('admin.administration.announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement): View
    {
        if (!$announcement->canBeEditedByUser(auth()->user())) {
            abort(403, 'Você não tem permissão para editar este comunicado.');
        }

        $departments = Department::active()->orderBy('name')->get();
        return view('admin.administration.announcements.edit', compact('announcement', 'departments'));
    }

    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        if (!$announcement->canBeEditedByUser(auth()->user())) {
            abort(403, 'Você não tem permissão para editar este comunicado.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,urgent,event,meeting',
            'priority' => 'required|in:low,normal,high,urgent',
            'department_id' => 'nullable|exists:departments,id',
            'is_active' => 'boolean',
            'published_at' => 'required|date',
            'expires_at' => 'nullable|date|after:published_at',
        ]);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'priority' => $request->priority,
            'department_id' => $request->department_id,
            'is_active' => $request->boolean('is_active'),
            'published_at' => $request->published_at,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()
            ->route('admin.administration.announcements.index')
            ->with('success', 'Comunicado atualizado com sucesso!');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        if (!$announcement->canBeEditedByUser(auth()->user())) {
            abort(403, 'Você não tem permissão para excluir este comunicado.');
        }

        $announcement->delete();

        return redirect()
            ->route('admin.administration.announcements.index')
            ->with('success', 'Comunicado excluído com sucesso!');
    }

    public function toggleStatus(Announcement $announcement): RedirectResponse
    {
        if (!$announcement->canBeEditedByUser(auth()->user())) {
            abort(403, 'Você não tem permissão para alterar este comunicado.');
        }

        $announcement->update(['is_active' => !$announcement->is_active]);

        return back()->with('success', 'Status do comunicado atualizado!');
    }
}
