@extends('layouts.admin')

@section('title', 'New Project')

@section('content')
    <div class="flex items-center justify-between">
        <div class="font-display text-3xl">New Project</div>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-ghost">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.projects.store') }}" class="mt-6 card p-6">
        @csrf
        @include('admin.projects._form', ['project' => null])
        <div class="mt-6">
            <button class="btn btn-primary" type="submit">Create</button>
        </div>
    </form>
@endsection

