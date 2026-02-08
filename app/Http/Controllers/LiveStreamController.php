<?php

namespace App\Http\Controllers;

use App\Models\LiveStream;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class LiveStreamController extends Controller
{
    public function index(Request $request): View
    {
        $query = LiveStream::with('creator')
            ->when($request->status, function ($q, $status) {
                $q->where('status', $status);
            })
            ->latest('scheduled_at');

        $streams = $query->paginate(15);
        
        return view('admin.media.livestreams.index', compact('streams'));
    }

    public function create(): View
    {
        return view('admin.media.livestreams.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'platform' => 'required|in:youtube,facebook,instagram,custom',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        $streamData = [
            'title' => $request->title,
            'description' => $request->description,
            'platform' => $request->platform,
            'stream_key' => $this->generateStreamKey(),
            'status' => 'scheduled',
            'created_by' => auth()->id(),
        ];

        if ($request->scheduled_at) {
            $streamData['scheduled_at'] = $request->scheduled_at;
        }

        $stream = LiveStream::create($streamData);

        return redirect()
            ->route('admin.media.livestreams.index')
            ->with('success', 'Transmissão agendada com sucesso!');
    }

    public function show(LiveStream $liveStream): View
    {
        $liveStream->load('creator');
        return view('admin.media.livestreams.show', compact('liveStream'));
    }

    public function edit(LiveStream $liveStream): View
    {
        return view('admin.media.livestreams.edit', compact('liveStream'));
    }

    public function update(Request $request, LiveStream $liveStream): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'platform' => 'required|in:youtube,facebook,instagram,custom',
            'scheduled_at' => 'nullable|date',
            'status' => 'required|in:scheduled,live,ended,cancelled',
        ]);

        $liveStream->update($request->only([
            'title',
            'description',
            'platform',
            'scheduled_at',
            'status',
        ]));

        return redirect()
            ->route('admin.media.livestreams.index')
            ->with('success', 'Transmissão atualizada com sucesso!');
    }

    public function destroy(LiveStream $liveStream): RedirectResponse
    {
        $liveStream->delete();

        return redirect()
            ->route('admin.media.livestreams.index')
            ->with('success', 'Transmissão excluída com sucesso!');
    }

    public function startStream(LiveStream $liveStream): RedirectResponse
    {
        if ($liveStream->status !== 'scheduled') {
            return back()->withErrors(['error' => 'Apenas transmissões agendadas podem ser iniciadas.']);
        }

        $liveStream->update([
            'status' => 'live',
            'started_at' => now(),
        ]);

        return back()->with('success', 'Transmissão iniciada!');
    }

    public function endStream(LiveStream $liveStream): RedirectResponse
    {
        if ($liveStream->status !== 'live') {
            return back()->withErrors(['error' => 'Apenas transmissões ao vivo podem ser encerradas.']);
        }

        $liveStream->update([
            'status' => 'ended',
            'ended_at' => now(),
        ]);

        return back()->with('success', 'Transmissão encerrada!');
    }

    public function regenerateKey(LiveStream $liveStream): RedirectResponse
    {
        $liveStream->update([
            'stream_key' => $this->generateStreamKey(),
        ]);

        return back()->with('success', 'Chave de transmissão regenerada!');
    }

    private function generateStreamKey(): string
    {
        return Str::random(32) . '-' . time();
    }

    public function getEmbedUrl(LiveStream $liveStream): string
    {
        return match($liveStream->platform) {
            'youtube' => "https://www.youtube.com/embed/{$liveStream->stream_key}",
            'facebook' => "https://www.facebook.com/plugins/video.php?href={$liveStream->stream_url}",
            'instagram' => $liveStream->embed_url,
            'custom' => $liveStream->embed_url,
            default => ''
        };
    }
}
