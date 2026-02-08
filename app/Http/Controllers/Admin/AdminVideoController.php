<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminVideoController extends Controller
{
    public function index()
    {
        return view('admin.videos.index', [
            'videos' => Video::query()->latest()->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:5000'],
            'provider' => ['required', 'string', 'max:40'],
            'provider_id' => ['nullable', 'string', 'max:255'],
            'thumbnail_url' => ['nullable', 'string', 'max:2048'],
            'is_published' => ['nullable'],
            'published_at' => ['nullable', 'date'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['is_published'] = (bool) $request->boolean('is_published');

        Video::create($data);

        return redirect()->route('admin.videos.index')->with('status', 'Video created.');
    }

    public function edit(Video $video)
    {
        return view('admin.videos.edit', ['video' => $video]);
    }

    public function update(Request $request, Video $video)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:5000'],
            'provider' => ['required', 'string', 'max:40'],
            'provider_id' => ['nullable', 'string', 'max:255'],
            'thumbnail_url' => ['nullable', 'string', 'max:2048'],
            'is_published' => ['nullable'],
            'published_at' => ['nullable', 'date'],
        ]);

        $data['is_published'] = (bool) $request->boolean('is_published');

        $video->update($data);

        return redirect()->route('admin.videos.index')->with('status', 'Video updated.');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->route('admin.videos.index')->with('status', 'Video deleted.');
    }

    public function show(Video $video)
    {
        return redirect()->route('admin.videos.edit', $video);
    }
}

