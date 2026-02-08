<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index', [
            'projects' => Project::query()
                ->where('is_published', true)
                ->latest('published_at')
                ->paginate(12),
        ]);
    }

    public function show(Project $project)
    {
        abort_unless($project->is_published, 404);

        $project->load('media');

        return view('projects.show', [
            'project' => $project,
        ]);
    }
}

