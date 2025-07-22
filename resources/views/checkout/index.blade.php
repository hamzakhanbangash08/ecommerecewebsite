@extends('layouts.master')

@section('content')
<div class="container py-4">
    {{-- 🧭 Breadcrumbs --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </nav>

    <h2 class="mb-4">🛒 Checkout</h2>

    <div class="row">
        {{-- Left: Billing & Shipping --}}
        <div class="col-md-7">
            {{-- Billing Details --}}
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">Billing Information</div>
                <div class="card-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="fname">First Name</label>
                                <input type="text" class="form-control" id="fname" placeholder="John">
                            </div>
                            <div class="col">
                                <label for="lname">Last Name</label>
                                <input type="text" class="form-control" id="lname" placeholder="Doe">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" placeholder="john@example.com">
                        </div>

                        <div class="mb-3">
                            <label for="address">Full Address</label>
                            <input type="text" class="form-control" id="address" placeholder="123 Main St">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="zip">Zip / Postal Code</label>
                                <input type="text" class="form-control" id="zip">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Shipping Method --}}
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">Shipping Method</div>
                <div class="card-body">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="shipping" id="standard" checked>
                        <label class="form-check-label" for="standard">
                            Standard (3-5 days) - Free
                        </label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="radio" name="shipping" id="express">
                        <label class="form-check-label" for="express">
                            Express (1-2 days) - $10
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Order Summary & Payment --}}
        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">🧾 Order Summary</div>
                <div class="card-body">
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div><strong>Product 1</strong><br><small>Quantity: 1</small></div>
                            <span>$50</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div><strong>Product 2</strong><br><small>Quantity: 2</small></div>
                            <span>$100</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Subtotal</strong>
                            <span>$150</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Shipping</strong>
                            <span>$0</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Total</strong>
                            <span class="text-success fw-bold">$150</span>
                        </li>
                    </ul>

                    {{-- Payment Method --}}
                    <h6>💳 Payment</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment" id="cod" checked>
                        <label class="form-check-label" for="cod">
                            Cash on Delivery
                        </label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="radio" name="payment" id="card">
                        <label class="form-check-label" for="card">
                            Credit / Debit Card
                        </label>
                    </div>

                    {{-- Place Order Button --}}
                    <button class="btn btn-success w-100 mt-4">Place Order</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection