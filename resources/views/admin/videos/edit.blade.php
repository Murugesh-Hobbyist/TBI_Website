@extends('layouts.admin')

@section('title', 'Edit Video')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <div class="font-display text-3xl">Edit Video</div>
            <div class="mt-2 text-sm text-white/60">Public URL: <a class="underline hover:text-white" href="{{ route('videos.show', $video) }}" target="_blank" rel="noreferrer">{{ route('videos.show', $video) }}</a></div>
        </div>
        <a href="{{ route('admin.videos.index') }}" class="btn btn-ghost">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.videos.update', $video) }}" class="mt-6 card p-6">
        @csrf
        @method('PUT')
        @include('admin.videos._form', ['video' => $video])
        <div class="mt-6 flex gap-3">
            <button class="btn btn-primary" type="submit">Save</button>
            <button class="btn btn-ghost" type="submit" form="delete-video" onclick="return confirm('Delete video?')">Delete</button>
        </div>
    </form>

    <form id="delete-video" method="POST" action="{{ route('admin.videos.destroy', $video) }}" class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endsection

