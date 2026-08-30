<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VideoController extends Controller
{
    public function index()
    {
        $videos = collect();

        try {
            $videos = Video::query()
                ->where('is_published', true)
                ->latest('published_at')
                ->get()
                ->map(fn (Video $video) => [
                    'title' => $video->title,
                    'summary' => $video->summary ?: 'A TwinBot project video.',
                    'youtube_id' => $video->provider === 'youtube' ? $video->provider_id : null,
                    'category' => 'Project Video',
                ])
                ->filter(fn (array $video) => filled($video['youtube_id']))
                ->values();
        } catch (\Throwable $e) {
            // Shared hosting can serve this page before a database is configured.
        }

        if ($videos->isEmpty()) {
            $videos = collect(config('twinbot.videos', []))
                ->map(fn (array $video) => [
                    'title' => trim((string) ($video['title'] ?? 'TwinBot Project Video')),
                    'summary' => trim((string) ($video['summary'] ?? 'A TwinBot automation project video.')),
                    'youtube_id' => trim((string) ($video['youtube_id'] ?? '')),
                    'category' => trim((string) ($video['category'] ?? 'Project Video')),
                ])
                ->filter(fn (array $video) => $video['youtube_id'] !== '')
                ->values();
        }

        return view('videos.index', [
            'videos' => $videos,
        ]);
    }

    public function show(string $video)
    {
        try {
            $video = Video::query()->where('slug', $video)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        } catch (\Throwable $e) {
            abort(503, 'Database not configured.');
        }

        abort_unless($video->is_published, 404);

        return view('videos.show', [
            'video' => $video,
        ]);
    }
}
