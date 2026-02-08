<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use App\Models\Expense;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class FinanceController extends Controller
{
    /**
     * Display a listing of contributions
     */
    public function contributions(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
            'search' => 'nullable|string|max:255',
            'type' => 'nullable|in:tithe,offering,special',
            'member_id' => 'nullable|integer|exists:members,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'payment_method' => 'nullable|in:cash,check,bank_transfer,credit_card,online',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $query = Contribution::with(['member']);

        // Apply filters
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('notes', 'like', '%' . $request->search . '%')
                  ->orWhere('reference', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->member_id) {
            $query->where('member_id', $request->member_id);
        }

        if ($request->start_date) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        if ($request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

        $contributions = $query->orderByDesc('date')
                            ->paginate($request->input('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $contributions
        ]);
    }

    /**
     * Display the specified contribution
     */
    public function showContribution(Request $request, int $id): JsonResponse
    {
        $contribution = Contribution::with(['member'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $contribution
        ]);
    }

    /**
     * Store a newly created contribution
     */
    public function storeContribution(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|integer|exists:members,id',
            'type' => 'required|in:tithe,offering,special',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date|before_or_equal:today',
            'payment_method' => 'required|in:cash,check,bank_transfer,credit_card,online',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'receipt_number' => 'nullable|string|max:255|unique:contributions,receipt_number',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate receipt number if not provided
        $data = $request->all();
        if (!$data['receipt_number']) {
            $data['receipt_number'] = 'REC-' . date('Y') . '-' . str_pad(Contribution::count() + 1, 6, '0', STR_PAD_LEFT);
        }

        $contribution = Contribution::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Contribution recorded successfully',
            'data' => $contribution->load(['member'])
        ], 201);
    }

    /**
     * Update the specified contribution
     */
    public function updateContribution(Request $request, int $id): JsonResponse
    {
        $contribution = Contribution::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'member_id' => 'required|integer|exists:members,id',
            'type' => 'required|in:tithe,offering,special',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date|before_or_equal:today',
            'payment_method' => 'required|in:cash,check,bank_transfer,credit_card,online',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'receipt_number' => 'nullable|string|max:255|unique:contributions,receipt_number,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $contribution->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Contribution updated successfully',
            'data' => $contribution->load(['member'])
        ]);
    }

    /**
     * Remove the specified contribution
     */
    public function destroyContribution(Request $request, int $id): JsonResponse
    {
        $contribution = Contribution::findOrFail($id);
        $contribution->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contribution deleted successfully'
        ]);
    }

    /**
     * Display a listing of expenses
     */
    public function expenses(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
            'search' => 'nullable|string|max:255',
            'category' => 'nullable|in:utilities,rent,supplies,marketing,events,staff,other',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'approved' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $query = Expense::with(['approvedBy']);

        // Apply filters
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('description', 'like', '%' . $request->search . '%')
                  ->orWhere('vendor', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->start_date) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        if ($request->approved !== null) {
            $query->where('approved', $request->approved);
        }

        $expenses = $query->orderByDesc('date')
                        ->paginate($request->input('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $expenses
        ]);
    }

    /**
     * Store a newly created expense
     */
    public function storeExpense(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date|before_or_equal:today',
            'category' => 'required|in:utilities,rent,supplies,marketing,events,staff,other',
            'vendor' => 'nullable|string|max:255',
            'receipt_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'approved' => 'nullable|boolean',
            'approved_by' => 'nullable|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $expense = Expense::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Expense recorded successfully',
            'data' => $expense->load(['approvedBy'])
        ], 201);
    }

    /**
     * Get financial statistics
     */
    public function statistics(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'period' => 'nullable|in:week,month,quarter,year',
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

        // Determine date range
        $startDate = $request->start_date ?? now()->startOfMonth();
        $endDate = $request->end_date ?? now()->endOfMonth();

        if ($request->period) {
            switch ($request->period) {
                case 'week':
                    $startDate = now()->startOfWeek();
                    $endDate = now()->endOfWeek();
                    break;
                case 'month':
                    $startDate = now()->startOfMonth();
                    $endDate = now()->endOfMonth();
                    break;
                case 'quarter':
                    $startDate = now()->startOfQuarter();
                    $endDate = now()->endOfQuarter();
                    break;
                case 'year':
                    $startDate = now()->startOfYear();
                    $endDate = now()->endOfYear();
                    break;
            }
        }

        $contributions = Contribution::whereBetween('date', [$startDate, $endDate])->get();
        $expenses = Expense::whereBetween('date', [$startDate, $endDate])->get();

        $stats = [
            'period' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ],
            'contributions' => [
                'total_amount' => $contributions->sum('amount'),
                'total_count' => $contributions->count(),
                'by_type' => $contributions->groupBy('type')
                                   ->map(function ($group) {
                                       return [
                                           'amount' => $group->sum('amount'),
                                           'count' => $group->count(),
                                       ];
                                   }),
                'by_payment_method' => $contributions->groupBy('payment_method')
                                           ->map(function ($group) {
                                               return [
                                                   'amount' => $group->sum('amount'),
                                                   'count' => $group->count(),
                                               ];
                                           }),
            ],
            'expenses' => [
                'total_amount' => $expenses->sum('amount'),
                'total_count' => $expenses->count(),
                'approved_amount' => $expenses->where('approved', true)->sum('amount'),
                'pending_amount' => $expenses->where('approved', false)->sum('amount'),
                'by_category' => $expenses->groupBy('category')
                                  ->map(function ($group) {
                                      return [
                                          'amount' => $group->sum('amount'),
                                          'count' => $group->count(),
                                      ];
                                  }),
            ],
            'summary' => [
                'net_amount' => $contributions->sum('amount') - $expenses->where('approved', true)->sum('amount'),
                'total_income' => $contributions->sum('amount'),
                'total_expenses' => $expenses->where('approved', true)->sum('amount'),
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get financial reports
     */
    public function reports(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:monthly,yearly,summary',
            'year' => 'nullable|integer|min:2020|max:2030',
            'month' => 'nullable|integer|min:1|max:12',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $year = $request->year ?? now()->year;
        $month = $request->month ?? now()->month;

        switch ($request->type) {
            case 'monthly':
                $startDate = Carbon::create($year, $month, 1);
                $endDate = $startDate->copy()->endOfMonth();
                break;
            case 'yearly':
                $startDate = Carbon::create($year, 1, 1);
                $endDate = Carbon::create($year, 12, 31);
                break;
            case 'summary':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;
        }

        $contributions = Contribution::whereBetween('date', [$startDate, $endDate])
                                  ->selectRaw('DATE(date) as date, SUM(amount) as total_amount, COUNT(*) as count')
                                  ->groupBy('date')
                                  ->orderBy('date')
                                  ->get();

        $expenses = Expense::whereBetween('date', [$startDate, $endDate])
                           ->where('approved', true)
                           ->selectRaw('DATE(date) as date, SUM(amount) as total_amount, COUNT(*) as count')
                           ->groupBy('date')
                           ->orderBy('date')
                           ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'period' => [
                    'type' => $request->type,
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                ],
                'contributions' => $contributions,
                'expenses' => $expenses,
            ]
        ]);
    }

    /**
     * Get budget information
     */
    public function budgets(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'year' => 'nullable|integer|min:2020|max:2030',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $year = $request->year ?? now()->year;

        $budgets = Budget::where('year', $year)
                        ->with(['expenses'])
                        ->get();

        return response()->json([
            'success' => true,
            'data' => $budgets
        ]);
    }
}
