<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class VideoController extends Controller
{
    public function index()
    {
        $dbOk = true;

        try {
            $videos = Video::query()
                ->where('is_published', true)
                ->latest('published_at')
                ->paginate(12);
        } catch (\Throwable $e) {
            $dbOk = false;
            $videos = new LengthAwarePaginator([], 0, 12, 1, [
                'path' => Paginator::resolveCurrentPath(),
            ]);
        }

        return view('videos.index', [
            'videos' => $videos,
            'dbOk' => $dbOk,
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
