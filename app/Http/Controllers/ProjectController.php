<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ProjectController extends Controller
{
    public function index()
    {
        $dbOk = true;

        try {
            $projects = Project::query()
                ->where('is_published', true)
                ->latest('published_at')
                ->paginate(12);
        } catch (\Throwable $e) {
            $dbOk = false;
            $projects = new LengthAwarePaginator([], 0, 12, 1, [
                'path' => Paginator::resolveCurrentPath(),
            ]);
        }

        return view('projects.index', [
            'projects' => $projects,
            'dbOk' => $dbOk,
        ]);
    }

    public function show(string $project)
    {
        try {
            $project = Project::query()->where('slug', $project)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        } catch (\Throwable $e) {
            abort(503, 'Database not configured.');
        }

        abort_unless($project->is_published, 404);

        $project->load('media');

        return view('projects.show', [
            'project' => $project,
        ]);
    }
}
