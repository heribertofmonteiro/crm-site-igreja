<?php

namespace App\Http\Controllers;

use App\Models\MediaCategory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MediaCategoryController extends Controller
{
    public function index(): View
    {
        $categories = MediaCategory::withCount('medias')
            ->latest()
            ->paginate(15);
            
        return view('admin.media.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.media.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:media_categories,name',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        MediaCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color ?? '#6c757d',
            'icon' => $request->icon,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('admin.media.categories.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    public function edit(MediaCategory $mediaCategory): View
    {
        return view('admin.media.categories.edit', compact('mediaCategory'));
    }

    public function update(Request $request, MediaCategory $mediaCategory): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:media_categories,name,' . $mediaCategory->id,
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $mediaCategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color ?? '#6c757d',
            'icon' => $request->icon,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.media.categories.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(MediaCategory $mediaCategory): RedirectResponse
    {
        if ($mediaCategory->medias()->exists()) {
            return back()->withErrors(['error' => 'Não é possível excluir uma categoria que possui mídias associadas.']);
        }

        $mediaCategory->delete();

        return redirect()
            ->route('admin.media.categories.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }
}
