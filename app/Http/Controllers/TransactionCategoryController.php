<?php

namespace App\Http\Controllers;

use App\Models\TransactionCategory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TransactionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = TransactionCategory::query()
            ->when($request->search, function ($q, $search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($request->type, function ($q, $type) {
                $q->where('type', $type);
            })
            ->when($request->parent_id !== null, function ($q) use ($request) {
                if ($request->parent_id === 'null') {
                    $q->whereNull('parent_id');
                } else {
                    $q->where('parent_id', $request->parent_id);
                }
            })
            ->orderBy('type')
            ->orderBy('name');

        $categories = $query->paginate(15);
        $parentCategories = TransactionCategory::whereNull('parent_id')->orderBy('name')->get();

        return view('admin.finance.transaction-categories.index', compact('categories', 'parentCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $parentCategories = TransactionCategory::whereNull('parent_id')->orderBy('name')->get();

        return view('admin.finance.transaction-categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|in:income,expense',
            'parent_id' => 'nullable|exists:transaction_categories,id',
            'is_active' => 'boolean',
        ]);

        TransactionCategory::create($validated);

        return redirect()
            ->route('admin.finance.transaction_categories.index')
            ->with('success', 'Categoria cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TransactionCategory $category): View
    {
        return view('admin.finance.transaction-categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionCategory $category): View
    {
        $parentCategories = TransactionCategory::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('admin.finance.transaction-categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransactionCategory $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|in:income,expense',
            'parent_id' => 'nullable|exists:transaction_categories,id',
            'is_active' => 'boolean',
        ]);

        $category->update($validated);

        return redirect()
            ->route('admin.finance.transaction_categories.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionCategory $category): RedirectResponse
    {
        if ($category->subcategories()->exists()) {
            return redirect()
                ->route('admin.finance.transaction_categories.index')
                ->with('error', 'Não é possível excluir esta categoria pois há subcategorias associadas.');
        }

        if ($category->transactions()->exists()) {
            return redirect()
                ->route('admin.finance.transaction_categories.index')
                ->with('error', 'Não é possível excluir esta categoria pois há transações associadas.');
        }

        $category->delete();

        return redirect()
            ->route('admin.finance.transaction_categories.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(TransactionCategory $category): RedirectResponse
    {
        $category->is_active = !$category->is_active;
        $category->save();

        return redirect()
            ->route('admin.finance.transaction_categories.index')
            ->with('success', 'Status atualizado!');
    }
}
