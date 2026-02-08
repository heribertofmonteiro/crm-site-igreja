<?php

namespace App\Http\Controllers;

use App\Models\WorshipTeam;
use App\Models\WorshipRehearsal;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WorshipTeamController extends Controller
{
    public function index(): View
    {
        $teams = WorshipTeam::with(['leader', 'rehearsals' => function ($query) {
            $query->latest('scheduled_at')->limit(3);
        }])
        ->withCount('rehearsals')
        ->active()
        ->latest()
        ->paginate(15);
        
        return view('admin.worship.teams.index', compact('teams'));
    }

    public function create(): View
    {
        $users = \App\Models\User::orderBy('name')->get();
        return view('admin.worship.teams.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'leader_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
        ]);

        WorshipTeam::create([
            'name' => $request->name,
            'description' => $request->description,
            'leader_id' => $request->leader_id,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('admin.worship.teams.index')
            ->with('success', 'Equipe criada com sucesso!');
    }

    public function show(WorshipTeam $worshipTeam): View
    {
        $worshipTeam->load(['leader', 'rehearsals' => function ($query) {
            $query->latest('scheduled_at');
        }]);
        
        return view('admin.worship.teams.show', compact('worshipTeam'));
    }

    public function edit(WorshipTeam $worshipTeam): View
    {
        $users = \App\Models\User::orderBy('name')->get();
        return view('admin.worship.teams.edit', compact('worshipTeam', 'users'));
    }

    public function update(Request $request, WorshipTeam $worshipTeam): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'leader_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
        ]);

        $worshipTeam->update([
            'name' => $request->name,
            'description' => $request->description,
            'leader_id' => $request->leader_id,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.worship.teams.index')
            ->with('success', 'Equipe atualizada com sucesso!');
    }

    public function destroy(WorshipTeam $worshipTeam): RedirectResponse
    {
        if ($worshipTeam->rehearsals()->exists()) {
            return back()->withErrors(['error' => 'Não é possível excluir uma equipe que possui ensaios.']);
        }

        $worshipTeam->delete();

        return redirect()
            ->route('admin.worship.teams.index')
            ->with('success', 'Equipe excluída com sucesso!');
    }

    public function scheduleRehearsal(Request $request, WorshipTeam $worshipTeam): RedirectResponse
    {
        $request->validate([
            'scheduled_at' => 'required|date|after:now',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        WorshipRehearsal::create([
            'worship_team_id' => $worshipTeam->id,
            'scheduled_at' => $request->scheduled_at,
            'location' => $request->location,
            'notes' => $request->notes,
            'status' => 'scheduled',
            'created_by' => Auth::id(),
        ]);

        return back()->with('success', 'Ensaio agendado com sucesso!');
    }

    public function startRehearsal(WorshipRehearsal $worshipRehearsal): RedirectResponse
    {
        if (!$worshipRehearsal->canStart()) {
            return back()->withErrors(['error' => 'Este ensaio não pode ser iniciado.']);
        }

        $worshipRehearsal->update([
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        return back()->with('success', 'Ensaio iniciado!');
    }

    public function completeRehearsal(WorshipRehearsal $worshipRehearsal): RedirectResponse
    {
        if (!$worshipRehearsal->canComplete()) {
            return back()->withErrors(['error' => 'Este ensaio não pode ser concluído.']);
        }

        $worshipRehearsal->update([
            'status' => 'completed',
            'ended_at' => now(),
        ]);

        return back()->with('success', 'Ensaio concluído!');
    }

    public function cancelRehearsal(WorshipRehearsal $worshipRehearsal): RedirectResponse
    {
        if (!$worshipRehearsal->canCancel()) {
            return back()->withErrors(['error' => 'Este ensaio não pode ser cancelado.']);
        }

        $worshipRehearsal->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Ensaio cancelado!');
    }
}
