<?php

namespace App\Http\Controllers;

use App\Models\Video;

class VideoController extends Controller
{
    public function index()
    {
        return view('videos.index', [
            'videos' => Video::query()
                ->where('is_published', true)
                ->latest('published_at')
                ->paginate(12),
        ]);
    }

    public function show(Video $video)
    {
        abort_unless($video->is_published, 404);

        return view('videos.show', [
            'video' => $video,
        ]);
    }
}

