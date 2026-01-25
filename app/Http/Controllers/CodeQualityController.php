<?php

namespace App\Http\Controllers;

use App\Models\CodeQualityReport;
use App\Models\FileAnalysis;
use App\Models\RefactoringTask;
use Illuminate\Http\Request;

class CodeQualityController extends Controller
{
    public function index()
    {
        // Latest report
        $latestReport = CodeQualityReport::latest('scan_date')->first();

        // Critical files (grade D or F)
        $criticalFilesCount = FileAnalysis::whereIn('grade', ['D', 'F'])->count();

        // Pending tasks
        $pendingTasks = RefactoringTask::where('status', 'pending')->count();

        // Evolution data (placeholder for now)
        $evolution = CodeQualityReport::orderBy('scan_date')->take(10)->get(['scan_date', 'average_complexity', 'technical_debt_hours']);

        return view('qualidade.index', compact('latestReport', 'criticalFilesCount', 'pendingTasks', 'evolution'));
    }

    public function criticalFiles()
    {
        $files = FileAnalysis::whereIn('grade', ['D', 'F'])
            ->orderBy('complexity', 'desc')
            ->paginate(50);

        return view('qualidade.critical', compact('files'));
    }

    public function queue()
    {
        $tasks = RefactoringTask::with('assignedUser')
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'asc')
            ->paginate(50);

        return view('qualidade.queue', compact('tasks'));
    }

    public function scan(Request $request)
    {
        // Trigger the scan command
        \Artisan::call('app:scan-code-quality');

        return redirect()->back()->with('success', 'Scan completed successfully.');
    }
}
