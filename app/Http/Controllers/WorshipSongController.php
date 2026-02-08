<?php

namespace App\Http\Controllers;

use App\Models\WorshipSong;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class WorshipSongController extends Controller
{
    public function index(Request $request): View
    {
        $query = WorshipSong::with('creator')
            ->when($request->search, function ($q, $search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('artist', 'like', "%{$search}%");
            })
            ->when($request->key, function ($q, $key) {
                $q->where('key', $key);
            })
            ->when($request->artist, function ($q, $artist) {
                $q->where('artist', 'like', "%{$artist}%");
            })
            ->active()
            ->latest();

        $songs = $query->paginate(15);
        
        return view('admin.worship.songs.index', compact('songs'));
    }

    public function create(): View
    {
        return view('admin.worship.songs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'nullable|string|max:255',
            'key' => 'nullable|string|max:10',
            'bpm' => 'nullable|integer|min:40|max:200',
            'duration' => 'nullable|integer|min:1',
            'lyrics' => 'nullable|string',
            'chords' => 'nullable|string',
            'ccli_number' => 'nullable|string|max:20',
            'youtube_link' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        WorshipSong::create([
            'title' => $request->title,
            'artist' => $request->artist,
            'key' => $request->key,
            'bpm' => $request->bpm,
            'duration' => $request->duration,
            'lyrics' => $request->lyrics,
            'chords' => $request->chords,
            'ccli_number' => $request->ccli_number,
            'youtube_link' => $request->youtube_link,
            'is_active' => $request->boolean('is_active', true),
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.worship.songs.index')
            ->with('success', 'Música cadastrada com sucesso!');
    }

    public function show(WorshipSong $worshipSong): View
    {
        $worshipSong->load(['creator', 'setlists' => function ($query) {
            $query->with('churchEvent')->latest('date')->limit(5);
        }]);
        
        return view('admin.worship.songs.show', compact('worshipSong'));
    }

    public function edit(WorshipSong $worshipSong): View
    {
        return view('admin.worship.songs.edit', compact('worshipSong'));
    }

    public function update(Request $request, WorshipSong $worshipSong): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'nullable|string|max:255',
            'key' => 'nullable|string|max:10',
            'bpm' => 'nullable|integer|min:40|max:200',
            'duration' => 'nullable|integer|min:1',
            'lyrics' => 'nullable|string',
            'chords' => 'nullable|string',
            'ccli_number' => 'nullable|string|max:20',
            'youtube_link' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        $worshipSong->update([
            'title' => $request->title,
            'artist' => $request->artist,
            'key' => $request->key,
            'bpm' => $request->bpm,
            'duration' => $request->duration,
            'lyrics' => $request->lyrics,
            'chords' => $request->chords,
            'ccli_number' => $request->ccli_number,
            'youtube_link' => $request->youtube_link,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.worship.songs.index')
            ->with('success', 'Música atualizada com sucesso!');
    }

    public function destroy(WorshipSong $worshipSong): RedirectResponse
    {
        if ($worshipSong->setlists()->exists()) {
            return back()->withErrors(['error' => 'Não é possível excluir uma música que está em setlists.']);
        }

        $worshipSong->delete();

        return redirect()
            ->route('admin.worship.songs.index')
            ->with('success', 'Música excluída com sucesso!');
    }

    public function chordSheet(WorshipSong $worshipSong): View
    {
        return view('admin.worship.songs.chord-sheet', compact('worshipSong'));
    }

    public function transpose(WorshipSong $worshipSong, Request $request): View
    {
        $request->validate([
            'target_key' => 'required|string|max:10',
        ]);

        $targetKey = $request->target_key;
        $originalKey = $worshipSong->key;
        
        // Simple transposition logic (basic implementation)
        $transposedLyrics = $this->transposeChords($worshipSong->lyrics, $originalKey, $targetKey);
        
        return view('admin.worship.songs.transposed', compact('worshipSong', 'transposedLyrics', 'targetKey'));
    }

    private function transposeChords(string $lyrics, ?string $fromKey, string $toKey): string
    {
        if (!$fromKey || !$lyrics) {
            return $lyrics;
        }

        // This is a simplified implementation
        // In a real scenario, you'd want more sophisticated chord transposition
        $chordMap = $this->getChordMap($fromKey, $toKey);
        
        foreach ($chordMap as $original => $transposed) {
            $lyrics = str_replace($original, $transposed, $lyrics);
        }
        
        return $lyrics;
    }

    private function getChordMap(string $from, string $to): array
    {
        $chromatic = ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'];
        $fromIndex = array_search(strtoupper($from), $chromatic);
        $toIndex = array_search(strtoupper($to), $chromatic);
        
        if ($fromIndex === false || $toIndex === false) {
            return [];
        }
        
        $semitones = $toIndex - $fromIndex;
        $map = [];
        
        foreach ($chromatic as $chord) {
            $index = array_search($chord, $chromatic);
            $newIndex = ($index + $semitones + 12) % 12;
            $map[$chord] = $chromatic[$newIndex];
        }
        
        return $map;
    }
}
