<?php

namespace App\Http\Controllers;

use App\Models\SocialPost;
use Illuminate\Http\Request;

class SocialPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:social_posts.view')->only(['index', 'show']);
        $this->middleware('permission:social_posts.create')->only(['create', 'store']);
        $this->middleware('permission:social_posts.edit')->only(['edit', 'update']);
        $this->middleware('permission:social_posts.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $socialPosts = SocialPost::with('user')->paginate(10);

        return view('admin.communication.social_posts.index', compact('socialPosts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.communication.social_posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'platform' => 'required|string|in:facebook,instagram,twitter,linkedin',
            'scheduled_at' => 'nullable|date|after:now',
            'media_url' => 'nullable|url',
        ]);

        SocialPost::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'platform' => $request->platform,
            'scheduled_at' => $request->scheduled_at,
            'media_url' => $request->media_url,
            'status' => $request->scheduled_at ? 'scheduled' : 'draft',
        ]);

        return redirect()->route('communication.social_posts.index')
            ->with('success', 'Post criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SocialPost $socialPost)
    {
        return view('admin.communication.social_posts.show', compact('socialPost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocialPost $socialPost)
    {
        return view('admin.communication.social_posts.edit', compact('socialPost'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SocialPost $socialPost)
    {
        $request->validate([
            'content' => 'required|string',
            'platform' => 'required|string|in:facebook,instagram,twitter,linkedin',
            'scheduled_at' => 'nullable|date|after:now',
            'media_url' => 'nullable|url',
            'status' => 'required|in:draft,scheduled,published',
        ]);

        $socialPost->update($request->only([
            'content', 'platform', 'scheduled_at', 'media_url', 'status'
        ]));

        if ($request->status === 'published' && !$socialPost->published_at) {
            $socialPost->update(['published_at' => now()]);
        }

        return redirect()->route('communication.social_posts.index')
            ->with('success', 'Post atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialPost $socialPost)
    {
        $socialPost->delete();

        return redirect()->route('communication.social_posts.index')
            ->with('success', 'Post removido com sucesso.');
    }
}