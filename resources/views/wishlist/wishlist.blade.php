@extends('layouts.master')

@section('title', 'My Wishlist')

@section('styles')
<style>
    .card:hover .card-img-top {
        transform: scale(1.05);
    }

    .transition {
        transition: all 0.3s ease-in-out;
    }

    .hover-shadow:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .z-3 {
        z-index: 3;
    }
</style>
@endsection

@section('pageTitle')
<h2 class="mb-4">My Wishlist</h2>
@endsection

@section('content')
<div class="container my-5">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        @forelse($wishlists as $product)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm rounded-4 position-relative hover-shadow transition">

                {{-- Remove from Wishlist --}}
                <form action="" method="POST"
                    class="position-absolute top-0 end-0 m-2 z-3">
                    @csrf
                    <button type="submit" class="btn btn-sm fw-bold rounded-circle">
                        <i class="bi bi-heart-fill text-danger"></i>
                    </button>
                </form>

                {{-- Product Image --}}
                <div class="overflow-hidden rounded-top-4 bg-light position-relative" style="height: 250px;">
                    <a href="">
                        <img src="{{ $product->product->image ? asset($product->product->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}"
                            class="card-img-top w-100 h-100 object-fit-cover transition" alt="{{ $product->product->name }}">
                    </a>
                </div>

                {{-- Card Body --}}
                <div class="card-body d-flex flex-column px-3 py-3">
                    <h6 class="fw-semibold text-dark mb-1">{{ Str::limit($product->product->name, 50) }}</h6>

                    {{-- Ratings --}}
                    <div class="text-warning small mb-1">
                        ★ ★ ★ ★ ☆
                    </div>

                    {{-- Description --}}
                    <p class="text-muted small mb-2">{{ Str::limit($product->product->description, 80) }}</p>

                    {{-- Price --}}
                    <h6 class="text-primary fw-bold mb-3">Rs. {{ number_format($product->product->price, 2) }}</h6>

                    {{-- Buttons --}}
                    <div class="d-grid gap-2 mt-auto">
                        <a href="{{ route('products.show', $product->id) }}"
                            class="btn btn-sm btn-outline-secondary rounded-pill">View Details</a>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-sm btn-primary rounded-pill">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <p class="text-muted">Your wishlist is empty.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection