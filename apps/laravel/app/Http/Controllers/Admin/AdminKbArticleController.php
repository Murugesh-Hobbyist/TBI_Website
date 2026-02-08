<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KbArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminKbArticleController extends Controller
{
    public function index()
    {
        return view('admin.kb.index', [
            'articles' => KbArticle::query()->latest()->paginate(30),
        ]);
    }

    public function create()
    {
        return view('admin.kb.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:400000'],
            'tags' => ['nullable', 'string', 'max:500'],
            'is_published' => ['nullable'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['is_published'] = (bool) $request->boolean('is_published');

        KbArticle::create($data);

        return redirect()->route('admin.kb.index')->with('status', 'KB article created.');
    }

    public function edit(KbArticle $kb)
    {
        return view('admin.kb.edit', ['article' => $kb]);
    }

    public function update(Request $request, KbArticle $kb)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:400000'],
            'tags' => ['nullable', 'string', 'max:500'],
            'is_published' => ['nullable'],
        ]);

        $data['is_published'] = (bool) $request->boolean('is_published');

        $kb->update($data);

        return redirect()->route('admin.kb.index')->with('status', 'KB article updated.');
    }

    public function destroy(KbArticle $kb)
    {
        $kb->delete();
        return redirect()->route('admin.kb.index')->with('status', 'KB article deleted.');
    }

    public function show(KbArticle $kb)
    {
        return redirect()->route('admin.kb.edit', $kb);
    }
}

