@extends('layouts.master')

@section('title', 'add to Cart')

@section('content')
<div class="container mt-4">
    <h4>Cart</h4>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($cart->count())
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Discount (%)</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $index => $item)
            @php
            $price = $item->price;
            $discount = $item->discount ?? 0;
            $subtotal = ($price * $item->quantity) * (1 - $discount / 100);
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->name ?? $item->product->name ?? 'N/A' }}</td>
                <td>
                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="quantity-form d-flex align-items-center" data-id="{{ $item->id }}">
                        @csrf
                        @method('PUT')
                        <button type="button" class="btn btn-sm btn-outline-secondary decrement">−</button>
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm mx-2 text-center" style="width: 60px;">
                        <button type="button" class="btn btn-sm btn-outline-secondary increment">+</button>
                    </form>
                </td>
                <td>Rs. {{ number_format($price, 2) }}</td>
                <td>{{ $discount }}%</td>
                <td>Rs. {{ number_format($subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot class="table-light">
            <tr>
                <td colspan="5" class="text-end fw-bold">Grand Total</td>
                <td class="fw-bold">
                    Rs. {{ number_format($cart->sum(fn($i) => ($i->price * $i->quantity) * (1 - ($i->discount ?? 0) / 100)), 2) }}
                </td>
            </tr>
        </tfoot>
    </table>
    @else
    <p>Your cart is empty.</p>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.quantity-form').forEach(form => {
        const input = form.querySelector('input[name="quantity"]');

        form.querySelector('.increment').addEventListener('click', () => {
            input.value = parseInt(input.value) + 1;
            form.submit();
        });

        form.querySelector('.decrement').addEventListener('click', () => {
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                form.submit();
            }
        });

        input.addEventListener('change', () => {
            if (parseInt(input.value) < 1) input.value = 1;
            form.submit();
        });
    });
</script>
@endsection