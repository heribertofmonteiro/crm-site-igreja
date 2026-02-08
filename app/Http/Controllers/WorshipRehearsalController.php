<?php

namespace App\Http\Controllers;

use App\Models\WorshipRehearsal;
use App\Models\WorshipTeam;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WorshipRehearsalController extends Controller
{
    public function index(Request $request): View
    {
        $query = WorshipRehearsal::with(['worshipTeam.leader', 'creator'])
            ->when($request->status, function ($q, $status) {
                $q->where('status', $status);
            })
            ->when($request->team_id, function ($q, $teamId) {
                $q->where('worship_team_id', $teamId);
            })
            ->latest('scheduled_at');

        $rehearsals = $query->paginate(15);
        $teams = WorshipTeam::active()->orderBy('name')->get();
        
        return view('admin.worship.rehearsals.index', compact('rehearsals', 'teams'));
    }

    public function create(): View
    {
        $teams = WorshipTeam::active()->orderBy('name')->get();
        return view('admin.worship.rehearsals.create', compact('teams'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'worship_team_id' => 'required|exists:worship_teams,id',
            'scheduled_at' => 'required|date|after:now',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        WorshipRehearsal::create([
            'worship_team_id' => $request->worship_team_id,
            'scheduled_at' => $request->scheduled_at,
            'location' => $request->location,
            'notes' => $request->notes,
            'status' => 'scheduled',
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.worship.rehearsals.index')
            ->with('success', 'Ensaio agendado com sucesso!');
    }

    public function show(WorshipRehearsal $worshipRehearsal): View
    {
        $worshipRehearsal->load(['worshipTeam.leader', 'creator']);
        
        return view('admin.worship.rehearsals.show', compact('worshipRehearsal'));
    }

    public function edit(WorshipRehearsal $worshipRehearsal): View
    {
        if ($worshipRehearsal->status !== 'scheduled') {
            return back()->withErrors(['error' => 'Apenas ensaios agendados podem ser editados.']);
        }

        $teams = WorshipTeam::active()->orderBy('name')->get();
        
        return view('admin.worship.rehearsals.edit', compact('worshipRehearsal', 'teams'));
    }

    public function update(Request $request, WorshipRehearsal $worshipRehearsal): RedirectResponse
    {
        if ($worshipRehearsal->status !== 'scheduled') {
            return back()->withErrors(['error' => 'Apenas ensaios agendados podem ser editados.']);
        }

        $request->validate([
            'worship_team_id' => 'required|exists:worship_teams,id',
            'scheduled_at' => 'required|date|after:now',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $worshipRehearsal->update([
            'worship_team_id' => $request->worship_team_id,
            'scheduled_at' => $request->scheduled_at,
            'location' => $request->location,
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('admin.worship.rehearsals.index')
            ->with('success', 'Ensaio atualizado com sucesso!');
    }

    public function destroy(WorshipRehearsal $worshipRehearsal): RedirectResponse
    {
        if ($worshipRehearsal->status === 'in_progress') {
            return back()->withErrors(['error' => 'Não é possível excluir um ensaio em andamento.']);
        }

        $worshipRehearsal->delete();

        return redirect()
            ->route('admin.worship.rehearsals.index')
            ->with('success', 'Ensaio excluído com sucesso!');
    }

    public function start(WorshipRehearsal $worshipRehearsal): RedirectResponse
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

    public function complete(WorshipRehearsal $worshipRehearsal): RedirectResponse
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

    public function cancel(WorshipRehearsal $worshipRehearsal): RedirectResponse
    {
        if (!$worshipRehearsal->canCancel()) {
            return back()->withErrors(['error' => 'Este ensaio não pode ser cancelado.']);
        }

        $worshipRehearsal->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Ensaio cancelado!');
    }

    public function calendar(): View
    {
        $rehearsals = WorshipRehearsal::with('worshipTeam')
            ->where('status', '!=', 'cancelled')
            ->get()
            ->map(function ($rehearsal) {
                return [
                    'id' => $rehearsal->id,
                    'title' => $rehearsal->worshipTeam->name,
                    'start' => $rehearsal->scheduled_at->toISOString(),
                    'backgroundColor' => $rehearsal->status === 'completed' ? '#28a745' : 
                                     ($rehearsal->status === 'in_progress' ? '#17a2b8' : '#ffc107'),
                    'borderColor' => $rehearsal->status === 'completed' ? '#1e7e34' : 
                                    ($rehearsal->status === 'in_progress' ? '#117a8b' : '#d39e00'),
                    'url' => route('admin.worship.rehearsals.show', $rehearsal),
                ];
            });

        return view('admin.worship.rehearsals.calendar', compact('rehearsals'));
    }
}
