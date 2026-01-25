<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:budgets.view')->only(['index', 'show']);
        $this->middleware('permission:budgets.create')->only(['create', 'store']);
        $this->middleware('permission:budgets.edit')->only(['edit', 'update']);
        $this->middleware('permission:budgets.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $budgets = Budget::paginate(10);
        return view('finance.budgets.index', compact('budgets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('finance.budgets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 10),
            'month' => 'required|integer|min:1|max:12',
            'category' => 'nullable|string|max:255',
        ]);

        Budget::create($request->all());

        return redirect()->route('finance.budgets.index')
            ->with('success', 'Orçamento criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        return view('finance.budgets.show', compact('budget'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
    {
        return view('finance.budgets.edit', compact('budget'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 10),
            'month' => 'required|integer|min:1|max:12',
            'category' => 'nullable|string|max:255',
        ]);

        $budget->update($request->all());

        return redirect()->route('finance.budgets.index')
            ->with('success', 'Orçamento atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        $budget->delete();

        return redirect()->route('finance.budgets.index')
            ->with('success', 'Orçamento removido com sucesso.');
    }
}
