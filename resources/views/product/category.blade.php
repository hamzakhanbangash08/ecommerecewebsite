@extends('layouts.master')

@section('title', 'Products in ' . $category->name)

@section('styles')
<style>
    .product-img {
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-img:hover {
        transform: scale(1.05);
    }
</style>

@endsection
@section('pageTitle')
<h2 class="mb-4">Products {{ $category->name }}</h2>
@endsection

@section('content')
<div class="container my-5">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        @forelse($products as $product)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm position-relative">

                {{-- Badge --}}
                @php
                $isNew = \Carbon\Carbon::parse($product->created_at)->gt(now()->subDays(7));
                @endphp
                <span class="position-absolute top-0 start-0 badge rounded-end bg-{{ $isNew ? 'success' : 'danger' }} m-2">
                    {{ $isNew ? 'New' : 'Sale' }}
                </span>

                {{-- Image --}}
                <div class="overflow-hidden">
                    <img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}"
                        class="card-img-top product-img" alt="{{ $product->name }}">
                </div>

                {{-- Card Body --}}
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-0">{{ $product->name }}</h5>

                    {{-- Ratings (Dummy 4 stars) --}}
                    <div class="mb-0">
                        <span class="text-warning">★ ★ ★ ★</span><span class="text-muted">★</span>
                    </div>

                    {{-- Description --}}
                    <p class="card-text text-muted small">{{ Str::limit($product->description, 100) }}</p>

                    {{-- Price and Buttons --}}
                    <div class="mt-auto">
                        <p class="fw-bold text-primary mb-2">Rs. {{ number_format($product->price, 2) }}</p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary">
                                View Details
                            </a>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                {{-- CSRF Token --}}
                                @csrf
                                @method('POST')

                                {{-- Hidden Inputs --}}
                                <input type="hidden" name="quantity" value="1">

                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <p class="text-muted">No products found in this category.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')

@endpush