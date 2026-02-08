<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\MediaCategory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Media::with(['category', 'uploader'])
            ->when($request->search, function ($q, $search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($request->type, function ($q, $type) {
                $q->where('file_type', $type);
            })
            ->when($request->category, function ($q, $category) {
                $q->where('media_category_id', $category);
            })
            ->latest();

        $medias = $query->paginate(12);
        $categories = MediaCategory::active()->orderBy('name')->get();
        
        return view('admin.media.index', compact('medias', 'categories'));
    }

    public function create(): View
    {
        $categories = MediaCategory::active()->orderBy('name')->get();
        return view('admin.media.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:102400', // 100MB max
            'media_category_id' => 'nullable|exists:media_categories,id',
            'is_published' => 'boolean',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('media', $fileName, 'public');

        $mediaData = [
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_type' => $this->getFileType($file->getMimeType()),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'media_category_id' => $request->media_category_id,
            'uploaded_by' => auth()->id(),
            'is_published' => $request->boolean('is_published'),
        ];

        if ($request->boolean('is_published')) {
            $mediaData['published_at'] = now();
        }

        // Extract duration for video/audio files
        if (in_array($mediaData['file_type'], ['video', 'audio'])) {
            $mediaData['duration'] = $this->getMediaDuration($filePath);
        }

        // Generate thumbnail for videos
        if ($mediaData['file_type'] === 'video') {
            $mediaData['thumbnail_path'] = $this->generateVideoThumbnail($filePath);
        }

        $media = Media::create($mediaData);

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Mídia cadastrada com sucesso!');
    }

    public function show(Media $media): View
    {
        $media->load(['category', 'uploader', 'playlists']);
        return view('admin.media.show', compact('media'));
    }

    public function edit(Media $media): View
    {
        $categories = MediaCategory::active()->orderBy('name')->get();
        return view('admin.media.edit', compact('media', 'categories'));
    }

    public function update(Request $request, Media $media): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'media_category_id' => 'nullable|exists:media_categories,id',
            'is_published' => 'boolean',
        ]);

        $mediaData = $request->only([
            'title',
            'description',
            'media_category_id',
        ]);

        $mediaData['is_published'] = $request->boolean('is_published');
        
        if ($mediaData['is_published'] && !$media->is_published) {
            $mediaData['published_at'] = now();
        } elseif (!$mediaData['is_published']) {
            $mediaData['published_at'] = null;
        }

        $media->update($mediaData);

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Mídia atualizada com sucesso!');
    }

    public function destroy(Media $media): RedirectResponse
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        // Delete thumbnail if exists
        if ($media->thumbnail_path && Storage::disk('public')->exists($media->thumbnail_path)) {
            Storage::disk('public')->delete($media->thumbnail_path);
        }

        $media->delete();

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Mídia excluída com sucesso!');
    }

    private function getFileType(string $mimeType): string
    {
        if (str_starts_with($mimeType, 'video/')) {
            return 'video';
        } elseif (str_starts_with($mimeType, 'audio/')) {
            return 'audio';
        } elseif (str_starts_with($mimeType, 'image/')) {
            return 'image';
        } else {
            return 'document';
        }
    }

    private function getMediaDuration(string $filePath): ?int
    {
        // Implement media duration extraction
        // This would require ffmpeg or similar library
        // For now, return null
        return null;
    }

    private function generateVideoThumbnail(string $filePath): ?string
    {
        // Implement video thumbnail generation
        // This would require ffmpeg or similar library
        // For now, return null
        return null;
    }
}
