<?php

namespace App\Console\Commands;

use App\Models\CodeQualityReport;
use App\Models\FileAnalysis;
use App\Models\RefactoringTask;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ScanCodeQuality extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scan-code-quality {--path=app : Directory to scan}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan code quality and generate reports';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = $this->option('path');
        $this->info("Scanning code quality in {$path}...");

        $files = $this->getPhpFiles(base_path($path));
        $this->info("Found " . count($files) . " PHP files");

        $totalComplexity = 0;
        $totalLines = 0;
        $fileAnalyses = [];

        foreach ($files as $file) {
            $analysis = $this->analyzeFile($file);
            $fileAnalyses[] = $analysis;
            $totalComplexity += $analysis['complexity'];
            $totalLines += $analysis['lines_of_code'];
        }

        // Create report
        $report = CodeQualityReport::create([
            'scan_date' => now(),
            'total_files' => count($files),
            'average_complexity' => count($files) > 0 ? $totalComplexity / count($files) : 0,
            'technical_debt_hours' => $this->estimateTechnicalDebt($fileAnalyses),
            'duplicated_lines' => $this->estimateDuplications($fileAnalyses),
        ]);

        // Save file analyses
        foreach ($fileAnalyses as $analysis) {
            FileAnalysis::updateOrCreate(
                ['file_path' => $analysis['file_path']],
                $analysis
            );
        }

        // Generate refactoring tasks for critical files
        $this->generateRefactoringTasks($fileAnalyses);

        $this->info("Scan completed. Report ID: {$report->id}");
    }

    private function getPhpFiles($directory)
    {
        $files = [];
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }

    private function analyzeFile($filePath)
    {
        $content = File::get($filePath);
        $lines = explode("\n", $content);
        $linesOfCode = count($lines);

        // Simple complexity calculation (count of control structures)
        $complexity = substr_count($content, 'if') + substr_count($content, 'for') + substr_count($content, 'while') +
                      substr_count($content, 'foreach') + substr_count($content, 'switch') + 1;

        // Simple maintainability index (placeholder)
        $maintainabilityIndex = max(0, 100 - ($complexity * 2) - ($linesOfCode / 10));

        // Grade based on complexity and lines
        $grade = $this->calculateGrade($complexity, $linesOfCode, $maintainabilityIndex);

        // Count issues (placeholder)
        $issuesCount = $complexity > 10 ? rand(1, 5) : 0;

        return [
            'file_path' => str_replace(base_path() . '/', '', $filePath),
            'grade' => $grade,
            'complexity' => $complexity,
            'lines_of_code' => $linesOfCode,
            'issues_count' => $issuesCount,
            'maintainability_index' => $maintainabilityIndex,
            'issues' => $issuesCount > 0 ? ['High complexity', 'Long method'] : [],
            'last_analyzed' => now(),
        ];
    }

    private function calculateGrade($complexity, $lines, $maintainability)
    {
        if ($complexity > 20 || $lines > 300 || $maintainability < 20) return 'F';
        if ($complexity > 15 || $lines > 200 || $maintainability < 40) return 'D';
        if ($complexity > 10 || $lines > 100 || $maintainability < 60) return 'C';
        if ($complexity > 5 || $maintainability < 80) return 'B';
        return 'A';
    }

    private function estimateTechnicalDebt($analyses)
    {
        $debt = 0;
        foreach ($analyses as $analysis) {
            if ($analysis['grade'] === 'F') $debt += 8;
            elseif ($analysis['grade'] === 'D') $debt += 4;
            elseif ($analysis['grade'] === 'C') $debt += 2;
        }
        return $debt;
    }

    private function estimateDuplications($analyses)
    {
        // Placeholder: assume 5% duplication
        return array_sum(array_column($analyses, 'lines_of_code')) * 0.05;
    }

    private function generateRefactoringTasks($analyses)
    {
        foreach ($analyses as $analysis) {
            if (in_array($analysis['grade'], ['D', 'F'])) {
                RefactoringTask::firstOrCreate(
                    ['file_path' => $analysis['file_path']],
                    [
                        'issue_type' => $analysis['complexity'] > 15 ? 'high_complexity' : 'code_smell',
                        'description' => "File has grade {$analysis['grade']} with complexity {$analysis['complexity']}",
                        'priority' => $analysis['grade'] === 'F' ? 'critical' : 'high',
                        'status' => 'pending',
                    ]
                );
            }
        }
    }
}
