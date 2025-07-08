@extends('layouts.master')

@section('title', 'Product Categorys')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Explore Categories</h3>
    <div class="row">
        @foreach ($categories as $category)
        <div class="col-md-4 mb-4">
            <a href="{{ route('categories.products', $category->id) }}" class="text-decoration-none">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <p class="text-muted">{{ $category->product()->count() }} items</p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection