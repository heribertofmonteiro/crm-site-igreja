<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogsController extends Controller
{
    public function index()
    {
        // Dashboard de Saúde
        $totalIncidents = Incident::count();
        $openIncidents = Incident::open()->count();
        $resolvedIncidents = Incident::resolved()->count();
        $totalActivities = Activity::count();

        // Basic health metrics (placeholder)
        $uptime = 99.9; // Placeholder
        $errorRate = Incident::where('level', 'error')->count();

        return view('logs.index', compact('totalIncidents', 'openIncidents', 'resolvedIncidents', 'totalActivities', 'uptime', 'errorRate'));
    }

    public function logs(Request $request)
    {
        // Simple log viewer
        return view('logs.logs');
    }

    public function audits(Request $request)
    {
        $activities = Activity::with('causer')->latest()->paginate(50);

        return view('logs.audits', compact('activities'));
    }

    public function incidents(Request $request)
    {
        $incidents = Incident::with('user')->latest()->paginate(50);

        return view('logs.incidents', compact('incidents'));
    }

    public function updateIncident(Request $request, Incident $incident)
    {
        $request->validate([
            'status' => 'required|in:open,investigating,resolved,closed',
        ]);

        $incident->update([
            'status' => $request->status,
            'resolved_at' => $request->status === 'resolved' ? now() : null,
        ]);

        return back()->with('success', 'Incident updated successfully.');
    }

    public function exportLogs()
    {
        // Export incidents as CSV
        $incidents = Incident::all();
        $filename = 'incidents_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($incidents) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'User', 'Level', 'Message', 'Status', 'Created At']);

            foreach ($incidents as $incident) {
                fputcsv($file, [
                    $incident->id,
                    $incident->user ? $incident->user->name : 'N/A',
                    $incident->level,
                    $incident->message,
                    $incident->status,
                    $incident->created_at,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function cleanupLogs()
    {
        // Delete incidents older than 30 days
        $deleted = Incident::where('created_at', '<', now()->subDays(30))->delete();

        return back()->with('success', "$deleted old incidents cleaned up.");
    }
}
