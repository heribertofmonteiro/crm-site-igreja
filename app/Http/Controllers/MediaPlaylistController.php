<?php

namespace App\Http\Controllers;

use App\Models\MediaPlaylist;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MediaPlaylistController extends Controller
{
    public function index(): View
    {
        $playlists = MediaPlaylist::with(['creator', 'medias'])
            ->withCount('medias')
            ->active()
            ->latest()
            ->paginate(15);
            
        return view('admin.media.playlists.index', compact('playlists'));
    }

    public function create(): View
    {
        $medias = Media::published()->latest()->get();
        return view('admin.media.playlists.create', compact('medias'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'medias' => 'required|array',
            'medias.*' => 'exists:medias,id',
            'is_active' => 'boolean',
        ]);

        $playlist = MediaPlaylist::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
            'created_by' => auth()->id(),
        ]);

        // Attach medias with order
        if ($request->has('medias')) {
            $order = 0;
            foreach ($request->medias as $mediaId) {
                $playlist->medias()->attach($mediaId, ['order' => $order]);
                $order++;
            }
        }

        return redirect()
            ->route('admin.media.playlists.index')
            ->with('success', 'Playlist criada com sucesso!');
    }

    public function show(MediaPlaylist $mediaPlaylist): View
    {
        $mediaPlaylist->load(['creator', 'medias' => function ($query) {
            $query->orderBy('order');
        }]);
        
        return view('admin.media.playlists.show', compact('mediaPlaylist'));
    }

    public function edit(MediaPlaylist $mediaPlaylist): View
    {
        $mediaPlaylist->load(['medias' => function ($query) {
            $query->orderBy('order');
        }]);
        
        $availableMedias = Media::published()
            ->whereNotIn('id', $mediaPlaylist->medias->pluck('id'))
            ->latest()
            ->get();
            
        return view('admin.media.playlists.edit', compact('mediaPlaylist', 'availableMedias'));
    }

    public function update(Request $request, MediaPlaylist $mediaPlaylist): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'medias' => 'nullable|array',
            'medias.*' => 'exists:medias,id',
            'is_active' => 'boolean',
        ]);

        $mediaPlaylist->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        // Update medias in playlist
        if ($request->has('medias')) {
            $mediaPlaylist->medias()->detach();
            $order = 0;
            foreach ($request->medias as $mediaId) {
                $mediaPlaylist->medias()->attach($mediaId, ['order' => $order]);
                $order++;
            }
        }

        return redirect()
            ->route('admin.media.playlists.index')
            ->with('success', 'Playlist atualizada com sucesso!');
    }

    public function destroy(MediaPlaylist $mediaPlaylist): RedirectResponse
    {
        $mediaPlaylist->medias()->detach();
        $mediaPlaylist->delete();

        return redirect()
            ->route('admin.media.playlists.index')
            ->with('success', 'Playlist excluída com sucesso!');
    }

    public function addMedia(Request $request, MediaPlaylist $mediaPlaylist): RedirectResponse
    {
        $request->validate([
            'media_id' => 'required|exists:medias,id',
        ]);

        $maxOrder = $mediaPlaylist->medias()->max('order') ?? 0;
        
        $mediaPlaylist->medias()->attach($request->media_id, [
            'order' => $maxOrder + 1
        ]);

        return back()->with('success', 'Mídia adicionada à playlist!');
    }

    public function removeMedia(MediaPlaylist $mediaPlaylist, Media $media): RedirectResponse
    {
        $mediaPlaylist->medias()->detach($media->id);
        
        // Reorder remaining items
        $medias = $mediaPlaylist->medias()->orderBy('order')->get();
        $order = 0;
        foreach ($medias as $mediaItem) {
            $mediaPlaylist->medias()->updateExistingPivot($mediaItem->id, ['order' => $order]);
            $order++;
        }

        return back()->with('success', 'Mídia removida da playlist!');
    }

    public function reorder(Request $request, MediaPlaylist $mediaPlaylist): RedirectResponse
    {
        $request->validate([
            'medias' => 'required|array',
            'medias.*' => 'exists:medias,id',
        ]);

        foreach ($request->medias as $order => $mediaId) {
            $mediaPlaylist->medias()->updateExistingPivot($mediaId, ['order' => $order]);
        }

        return back()->with('success', 'Playlist reordenada!');
    }
}
