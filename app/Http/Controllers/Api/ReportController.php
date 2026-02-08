<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReportTemplate;
use App\Models\GeneratedReport;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of report templates
     */
    public function templates(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
            'search' => 'nullable|string|max:255',
            'category' => 'nullable|in:members,finance,events,general',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $query = ReportTemplate::query();

        // Apply filters
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $templates = $query->orderBy('name')
                        ->paginate($request->input('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $templates
        ]);
    }

    /**
     * Display the specified report template
     */
    public function showTemplate(Request $request, int $id): JsonResponse
    {
        $template = ReportTemplate::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $template
        ]);
    }

    /**
     * Store a newly created report template
     */
    public function storeTemplate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:members,finance,events,general',
            'query' => 'required|string',
            'parameters' => 'nullable|array',
            'parameters.*.name' => 'required|string|max:255',
            'parameters.*.type' => 'required|in:text,date,number,boolean',
            'parameters.*.required' => 'required|boolean',
            'parameters.*.default' => 'nullable',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['status'] = $data['status'] ?? 'active';

        $template = ReportTemplate::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Report template created successfully',
            'data' => $template
        ], 201);
    }

    /**
     * Update the specified report template
     */
    public function updateTemplate(Request $request, int $id): JsonResponse
    {
        $template = ReportTemplate::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:members,finance,events,general',
            'query' => 'required|string',
            'parameters' => 'nullable|array',
            'parameters.*.name' => 'required|string|max:255',
            'parameters.*.type' => 'required|in:text,date,number,boolean',
            'parameters.*.required' => 'required|boolean',
            'parameters.*.default' => 'nullable',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $template->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Report template updated successfully',
            'data' => $template
        ]);
    }

    /**
     * Remove the specified report template
     */
    public function destroyTemplate(Request $request, int $id): JsonResponse
    {
        $template = ReportTemplate::findOrFail($id);
        $template->delete();

        return response()->json([
            'success' => true,
            'message' => 'Report template deleted successfully'
        ]);
    }

    /**
     * Generate a report
     */
    public function generate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'template_id' => 'required|integer|exists:report_templates,id',
            'parameters' => 'nullable|array',
            'format' => 'nullable|in:json,csv,pdf',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $template = ReportTemplate::findOrFail($request->template_id);

        // Validate template parameters
        if ($template->parameters) {
            foreach ($template->parameters as $param) {
                if ($param['required'] && !isset($request->parameters[$param['name']])) {
                    return response()->json([
                        'success' => false,
                        'message' => "Required parameter '{$param['name']}' is missing",
                    ], 422);
                }
            }
        }

        // Generate report data (simplified for this example)
        $reportData = $this->executeReportQuery($template, $request->parameters ?? []);

        // Create generated report record
        $generatedReport = GeneratedReport::create([
            'template_id' => $template->id,
            'user_id' => $this->getCurrentUserId($request),
            'parameters' => $request->parameters ?? [],
            'data' => $reportData,
            'format' => $request->format ?? 'json',
            'file_path' => null, // Will be set when file is generated
            'status' => 'completed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Report generated successfully',
            'data' => $generatedReport
        ]);
    }

    /**
     * Display a listing of generated reports
     */
    public function generated(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
            'template_id' => 'nullable|integer|exists:report_templates,id',
            'status' => 'nullable|in:pending,completed,failed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $query = GeneratedReport::with(['template', 'user']);

        // Apply filters
        if ($request->template_id) {
            $query->where('template_id', $request->template_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $reports = $query->orderByDesc('created_at')
                        ->paginate($request->input('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $reports
        ]);
    }

    /**
     * Display the specified generated report
     */
    public function showGenerated(Request $request, int $id): JsonResponse
    {
        $report = GeneratedReport::with(['template', 'user'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $report
        ]);
    }

    /**
     * Download a generated report
     */
    public function download(Request $request, int $id): JsonResponse
    {
        $report = GeneratedReport::findOrFail($id);

        if ($report->status !== 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Report is not ready for download'
            ], 400);
        }

        // Generate file based on format
        $format = $report->format ?? 'json';
        $filename = $report->template->name . '_' . $report->created_at->format('Y-m-d_H-i-s') . '.' . $format;

        switch ($format) {
            case 'json':
                $content = json_encode($report->data, JSON_PRETTY_PRINT);
                $mimeType = 'application/json';
                break;
            case 'csv':
                $content = $this->generateCsv($report->data);
                $mimeType = 'text/csv';
                break;
            case 'pdf':
                // PDF generation would require additional libraries
                return response()->json([
                    'success' => false,
                    'message' => 'PDF download not implemented yet'
                ], 501);
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Unsupported format'
                ], 400);
        }

        // Store file
        $filePath = 'reports/' . $filename;
        Storage::disk('public')->put($filePath, $content);

        // Update report record
        $report->update(['file_path' => $filePath]);

        return response()->json([
            'success' => true,
            'message' => 'Report file generated successfully',
            'data' => [
                'file_path' => $filePath,
                'download_url' => Storage::url($filePath),
                'filename' => $filename,
                'mime_type' => $mimeType,
            ]
        ]);
    }

    /**
     * Get report statistics
     */
    public function statistics(Request $request): JsonResponse
    {
        $stats = [
            'total_templates' => ReportTemplate::count(),
            'active_templates' => ReportTemplate::where('status', 'active')->count(),
            'total_reports' => GeneratedReport::count(),
            'completed_reports' => GeneratedReport::where('status', 'completed')->count(),
            'reports_this_month' => GeneratedReport::whereMonth('created_at', now()->month)
                                          ->whereYear('created_at', now()->year)
                                          ->count(),
            'templates_by_category' => ReportTemplate::selectRaw('category, COUNT(*) as count')
                                        ->groupBy('category')
                                        ->get(),
            'most_used_templates' => ReportTemplate::withCount('generatedReports')
                                        ->orderByDesc('generated_reports_count')
                                        ->limit(5)
                                        ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Execute report query (simplified implementation)
     */
    private function executeReportQuery(ReportTemplate $template, array $parameters): array
    {
        // This is a simplified implementation
        // In a real application, you would parse the SQL query and execute it safely
        // For now, we'll return mock data based on the template category

        switch ($template->category) {
            case 'members':
                return [
                    'total_members' => 150,
                    'active_members' => 120,
                    'new_members' => 15,
                    'members_by_status' => [
                        'active' => 120,
                        'inactive' => 20,
                        'visitor' => 10,
                    ],
                ];
            case 'finance':
                return [
                    'total_income' => 50000.00,
                    'total_expenses' => 30000.00,
                    'net_amount' => 20000.00,
                    'contributions_by_type' => [
                        'tithe' => 30000.00,
                        'offering' => 15000.00,
                        'special' => 5000.00,
                    ],
                ];
            case 'events':
                return [
                    'total_events' => 25,
                    'upcoming_events' => 5,
                    'completed_events' => 18,
                    'events_by_type' => [
                        'service' => 10,
                        'meeting' => 8,
                        'conference' => 3,
                        'social' => 4,
                    ],
                ];
            default:
                return [
                    'summary' => 'General report data',
                    'generated_at' => now()->toISOString(),
                ];
        }
    }

    /**
     * Generate CSV from data
     */
    private function generateCsv(array $data): string
    {
        $csv = "";
        $headers = [];

        // Extract headers from first level of data
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subKey => $subValue) {
                    $headers[] = $key . "_" . $subKey;
                }
            } else {
                $headers[] = $key;
            }
        }

        // Add headers
        $csv .= implode(",", $headers) . "\n";

        // Add data row
        $row = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subValue) {
                    $row[] = is_numeric($subValue) ? $subValue : '"' . $subValue . '"';
                }
            } else {
                $row[] = is_numeric($value) ? $value : '"' . $value . '"';
            }
        }
        $csv .= implode(",", $row) . "\n";

        return $csv;
    }

    /**
     * Get current user ID (simplified)
     */
    private function getCurrentUserId(Request $request): ?int
    {
        // In a real application, you would get this from the authenticated user
        // For now, we'll return null
        return null;
    }
}
