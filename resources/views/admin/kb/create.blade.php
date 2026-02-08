@extends('layouts.admin')

@section('title', 'New KB Article')

@section('content')
    <div class="flex items-center justify-between">
        <div class="font-display text-3xl">New KB Article</div>
        <a href="{{ route('admin.kb.index') }}" class="btn btn-ghost">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.kb.store') }}" class="mt-6 card p-6">
        @csrf
        @include('admin.kb._form', ['article' => null])
        <div class="mt-6">
            <button class="btn btn-primary" type="submit">Create</button>
        </div>
    </form>
@endsection

