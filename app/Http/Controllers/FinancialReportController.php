<?php

namespace App\Http\Controllers;

use App\Models\FinancialReport;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\FinancialTransaction;
use App\Models\FinancialAccount;
use App\Models\TransactionCategory;
use Barryvdh\DomPDF\Facade\Pdf;

class FinancialReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = FinancialReport::query()
            ->when($request->search, function ($q, $search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->when($request->report_type, function ($q, $type) {
                $q->where('report_type', $type);
            })
            ->when($request->status, function ($q, $status) {
                $q->where('status', $status);
            })
            ->when($request->date_from, function ($q, $date) {
                $q->whereDate('period_start', '>=', $date);
            })
            ->when($request->date_to, function ($q, $date) {
                $q->whereDate('period_end', '<=', $date);
            })
            ->orderBy('created_at', 'desc');

        $reports = $query->paginate(15);

        return view('admin.finance.reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.finance.reports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'report_type' => 'required|string|in:monthly,quarterly,annual,custom',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after:period_start',
        ]);

        // Generate report data
        $data = $this->generateReportData(
            $validated['period_start'],
            $validated['period_end']
        );

        $validated['data'] = $data;
        $validated['generated_by'] = auth()->user()?->name ?? 'Sistema';
        $validated['status'] = FinancialReport::STATUS_GENERATED;

        $report = FinancialReport::create($validated);

        return redirect()
            ->route('admin.finance.financial_reports.index')
            ->with('success', 'Relatório gerado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(FinancialReport $report): View
    {
        return view('admin.finance.reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinancialReport $report): View
    {
        return view('admin.finance.reports.edit', compact('report'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FinancialReport $report): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:draft,generated,approved,archived',
        ]);

        $report->update($validated);

        return redirect()
            ->route('admin.finance.financial_reports.index')
            ->with('success', 'Relatório atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinancialReport $report): RedirectResponse
    {
        $report->delete();

        return redirect()
            ->route('admin.finance.financial_reports.index')
            ->with('success', 'Relatório excluído!');
    }

    /**
     * Regenerate report.
     */
    public function regenerate(FinancialReport $report): RedirectResponse
    {
        $data = $this->generateReportData($report->period_start, $report->period_end);

        $report->update([
            'data' => $data,
            'generated_by' => auth()->user()?->name ?? 'Sistema',
            'status' => FinancialReport::STATUS_GENERATED,
        ]);

        return redirect()
            ->route('admin.finance.financial_reports.show', $report)
            ->with('success', 'Relatório regenerado!');
    }

    /**
     * Approve report.
     */
    public function approve(FinancialReport $report): RedirectResponse
    {
        $report->update(['status' => FinancialReport::STATUS_APPROVED]);

        return redirect()
            ->route('admin.finance.financial_reports.index')
            ->with('success', 'Relatório aprovado!');
    }

    /**
     * Archive report.
     */
    public function archive(FinancialReport $report): RedirectResponse
    {
        $report->update(['status' => FinancialReport::STATUS_ARCHIVED]);

        return redirect()
            ->route('admin.finance.financial_reports.index')
            ->with('success', 'Relatório arquivado!');
    }

    /**
     * Export report to PDF.
     */
    public function exportPdf(FinancialReport $report)
    {
        $pdf = Pdf::loadView('admin.finance.reports.pdf', compact('report'));

        return $pdf->download('relatorio_financeiro_' . $report->id . '.pdf');
    }

    /**
     * Generate report data.
     */
    protected function generateReportData($startDate, $endDate)
    {
        // Income summary
        $incomes = FinancialTransaction::where('type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->sum('amount');

        // Expense summary
        $expenses = FinancialTransaction::where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->sum('amount');

        // Balance
        $balance = $incomes - $expenses;

        // Income by category
        $incomeByCategory = FinancialTransaction::where('type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->with('category')
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->get();

        // Expense by category
        $expenseByCategory = FinancialTransaction::where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->with('category')
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->get();

        // Monthly trend
        $monthlyTrend = FinancialTransaction::whereBetween('transaction_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select(
                DB::raw('DATE_FORMAT(transaction_date, "%Y-%m") as month'),
                DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
                DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'period_start' => $startDate->format('Y-m-d'),
            'period_end' => $endDate->format('Y-m-d'),
            'total_income' => $incomes,
            'total_expense' => $expenses,
            'balance' => $balance,
            'income_by_category' => $incomeByCategory,
            'expense_by_category' => $expenseByCategory,
            'monthly_trend' => $monthlyTrend,
        ];
    }
}
