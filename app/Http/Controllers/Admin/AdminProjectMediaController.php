<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProjectMediaController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $data = $request->validate([
            'type' => ['required', 'string', 'max:40'],
            'title' => ['nullable', 'string', 'max:255'],
            'external_url' => ['nullable', 'string', 'max:2048'],
            'file' => ['nullable', 'file', 'max:10240'], // 10MB
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store("projects/{$project->id}", 'public');
        }

        ProjectMedia::create([
            'project_id' => $project->id,
            'type' => $data['type'],
            'title' => $data['title'] ?? null,
            'path' => $path,
            'external_url' => $data['external_url'] ?? null,
            'sort_order' => 0,
        ]);

        return redirect()->route('admin.projects.edit', $project)->with('status', 'Media added.');
    }

    public function destroy(ProjectMedia $media)
    {
        $projectId = $media->project_id;
        $path = $media->path;
        $media->delete();

        if ($path) {
            Storage::disk('public')->delete($path);
        }

        return redirect()->route('admin.projects.edit', $projectId)->with('status', 'Media removed.');
    }
}

