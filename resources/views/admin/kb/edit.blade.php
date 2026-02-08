@extends('layouts.admin')

@section('title', 'Edit KB Article')

@section('content')
    <div class="flex items-center justify-between">
        <div class="font-display text-3xl">Edit KB Article</div>
        <a href="{{ route('admin.kb.index') }}" class="btn btn-ghost">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.kb.update', $article) }}" class="mt-6 card p-6">
        @csrf
        @method('PUT')
        @include('admin.kb._form', ['article' => $article])
        <div class="mt-6 flex gap-3">
            <button class="btn btn-primary" type="submit">Save</button>
            <button class="btn btn-ghost" type="submit" form="delete-kb" onclick="return confirm('Delete article?')">Delete</button>
        </div>
    </form>

    <form id="delete-kb" method="POST" action="{{ route('admin.kb.destroy', $article) }}" class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endsection

