@extends('layouts.master')

@section('title', $product->name)

@section('styles')
<style>
    .wishlist-btn {
        background: none;
        border: none;
        color: #ff3e6c;
        font-size: 1.3rem;
        transition: transform 0.2s ease, color 0.3s ease;
    }

    .wishlist-btn:hover {
        transform: scale(1.2);
        color: #c82333;
    }

    .wishlist-btn:disabled {
        color: #bbb;
        cursor: not-allowed;
    }

    .star {
        transition: transform 0.3s ease;
        cursor: pointer;
    }

    .star:hover {
        transform: scale(1.2);
    }

    .star.selected {
        animation: bounce 0.2s;
    }

    @keyframes bounce {
        0% {
            transform: scale(1.1);
        }

        50% {
            transform: scale(0.95);
        }

        100% {
            transform: scale(1);
        }
    }
</style>


@endsection

@section('pageTitle')
<!-- Breadcrumbs Start -->
<nav aria-label="breadcrumb" class="mt-3">
    <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
        <li class="breadcrumb-item" itemprop="itemListElement" itemscope
            itemtype="https://schema.org/ListItem">
            <a href="{{ url('/') }}" itemprop="item">
                <span itemprop="name">Home</span>
            </a>
            <meta itemprop="position" content="1" />
        </li>

        <li class="breadcrumb-item" itemprop="itemListElement" itemscope
            itemtype="https://schema.org/ListItem">
            <a href="{{ route('products.index') }}" itemprop="item">
                <span itemprop="name">Products</span>
            </a>
            <meta itemprop="position" content="2" />
        </li>

        <li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope
            itemtype="https://schema.org/ListItem">
            <span itemprop="name">{{ $product->name }}</span>
            <meta itemprop="position" content="3" />
        </li>
    </ol>
</nav>
<!-- Breadcrumbs End -->

@endsection
@section('content')
<div class="container mt-5">
    <div class="row">
        {{-- Product Details --}}
        <div class="col-md-4 justify-content-center align-items-center mx-3 d-flex gap-3 mb-4 mb-md-0">

            {{-- Product Image --}}
            <img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/300x200?text=No+Image'}}"
                class="card-img-top rounded w-100 h-100 ms-0 ms-md-5 object-fit-cover transition img-fluid" alt="{{ $product->name }}">
        </div>

        <div class="col-md-6">
            {{-- Product Name, Description, and Price --}}
            <h3>{{ $product->name }}</h3>
            <p>{{ $product->description }}</p>
            <h4>Rs. {{ number_format($product->price, 2) }}</h4>

            {{-- Wishlist Button --}}
            <div class="mt-3">
                @if(in_array($product->id, $wishlistProductIds))
                <button class="btn btn-outline-danger" disabled data-bs-toggle="tooltip" data-bs-placement="right" title="Already in Wishlist">
                    <i class="fa fa-heart"></i> In Wishlist
                </button>
                @else
                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Wishlist">
                        <i class="fa fa-heart"></i> Add to Wishlist
                    </button>
                </form>
                @endif
            </div>

            {{-- Add to Cart --}}
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
        </div>


        <!-- rating this product -->
        <div class="row">
            <div class="col-md-8 mt-4 ms-2 ms-md-5 ">
                <h6>Rate this product:</h6>

                @php
                $avg = round($product->ratings()->avg('rating'), 1);
                @endphp

                {{-- Display average rating --}}
                @if(auth()->check())
                <form action="{{ route('ratings.store', $product->id) }}" method="POST" id="rating-form" class="mb-4">
                    @csrf
                    <label class="form-label">⭐ Rate this product:</label>

                    <div id="star-rating" class="mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="far fa-star fa-2x text-warning star" data-value="{{ $i }}"></i>
                            @endfor
                    </div>

                    <input type="hidden" name="rating" id="rating-input">
                    <textarea name="comment" class="form-control" rows="3" placeholder="Write a comment (optional)"></textarea>

                    <button type="submit" class="btn btn-primary mt-2 px-4">Submit Rating</button>
                </form>
                @endif

                <hr>

                <!-- Ratings Display -->
                <h5 class="mb-3">User Reviews</h5>
                @foreach ($product->ratings as $rating)
                <div class="border p-3 rounded mb-3">
                    <strong>{{ $rating->user->name }}</strong>

                    <div>
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <=$rating->rating)
                            <i class="fas fa-star text-warning"></i>
                            @else
                            <i class="far fa-star text-warning"></i>
                            @endif
                            @endfor
                            <small class="text-muted ms-2">{{ $rating->created_at->diffForHumans() }}</small>
                    </div>

                    @if($rating->comment)
                    <p class="mt-1 mb-2">{{ $rating->comment }}</p>
                    @endif

                    <!-- Helpful / Not Helpful -->
                    @if(auth()->check())
                    <form action="{{ route('ratings.vote', $rating->id) }}" method="POST" class="d-inline me-2">
                        @csrf
                        <input type="hidden" name="helpful" value="1">
                        <button class="btn btn-sm btn-outline-success">👍 Helpful</button>
                    </form>

                    <form action="{{ route('ratings.vote', $rating->id) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="helpful" value="0">
                        <button class="btn btn-sm btn-outline-danger">👎 Not Helpful</button>
                    </form>
                    @endif
                </div>
                @endforeach

            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mt-4 ms-2 ms-md-5">
                <div class="mb-4">
                    <h6>📊 Rating Summary</h6>

                    @foreach($breakdown as $star => $data)
                    <div class="d-flex align-items-center mb-1">
                        <div style="width: 50px;">⭐ {{ $star }}</div>
                        <div class="progress flex-grow-1 mx-2" style="height: 14px;">
                            <div class="progress-bar bg-warning" role="progressbar"
                                style="width: {{ $data['percentage'] }}%;" aria-valuenow="{{ $data['percentage'] }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div style="width: 40px;" class="text-end">{{ $data['percentage'] }}%</div>
                    </div>
                    @endforeach

                    <small class="text-muted">Total Ratings: {{ $totalRatings }}</small>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('scripts')
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });


        //star per click ho ke count ho

        const stars = document.querySelectorAll('#star-rating .star');
        const ratingInput = document.getElementById('rating-input');

        stars.forEach(star => {
            // Hover effect
            star.addEventListener('mouseover', function() {
                highlightStars(this.getAttribute('data-value'));
            });

            // Remove hover effect
            star.addEventListener('mouseout', function() {
                highlightStars(ratingInput.value);
            });

            // Click to rate
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                ratingInput.value = value;
                highlightStars(value);
            });
        });

        function highlightStars(value) {
            stars.forEach(star => {
                const starValue = parseInt(star.getAttribute('data-value'));
                if (starValue <= value) {
                    star.classList.remove('far');
                    star.classList.add('fas', 'selected');
                } else {
                    star.classList.add('far');
                    star.classList.remove('fas', 'selected');
                }
            });
        }
    </script>

    @endsection