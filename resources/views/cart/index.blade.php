@extends('layouts.master')

@section('title', 'Your Cart')


@section('content')
<div class="container mt-4">
    <h4>Your Cart</h4>

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
                <td>{{ $item->quantity }}</td>
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