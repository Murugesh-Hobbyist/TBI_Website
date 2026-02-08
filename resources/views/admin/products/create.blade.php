@extends('layouts.admin')

@section('title', 'New Product')

@section('content')
    <div class="flex items-center justify-between">
        <div class="font-display text-3xl">New Product</div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.products.store') }}" class="mt-6 card p-6">
        @csrf
        @include('admin.products._form', ['product' => null])
        <div class="mt-6">
            <button class="btn btn-primary" type="submit">Create</button>
        </div>
    </form>
@endsection

