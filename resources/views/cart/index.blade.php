@extends('layouts.master')

@section('title', 'add to Cart')

@section('content')
<div class="container mt-4">
    <h4>Cart</h4>

    @if($cart->count())
    <table class="table table-bordered table-hover text-center">
        <thead class="table-light">
            <tr class="justify-content-center">
                <th>#</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Discount (%)</th>
                <th>Subtotal</th>
                <th>Action</th>
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
                <td class="text-center">
                    <form class="quantity-form d-flex align-items-center"
                        data-id="{{ $item->id }}"
                        data-price="{{ $item->price }}"
                        data-discount="{{ $discount }}"
                        data-route="{{ route('cart.update', $item->id) }}">

                        <button class="btn btn-sm btn-light decrement">-</button>

                        <input type="number" name="quantity"
                            value="{{ $item->quantity }}"
                            min="1"
                            class="form-control form-control-sm mx-2 text-center"
                            style="width: 60px;">

                        <button class="btn btn-sm btn-light increment">+</button>
                    </form>
                </td>
                <td>Rs. {{ number_format($price, 2) }}</td>
                <td>{{ $discount }}%</td>
                <td id="subtotal-{{ $item->id }}">Rs. {{ number_format($subtotal, 2) }}</td>
                <td>
                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm border-0 bg-transparent text-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot class="table-light">
            <tr>
                <td colspan="5" class="text-end fw-bold">Grand Total</td>
                <td class="fw-bold" id="grand-total">
                    Rs. {{ number_format($cart->sum(fn($i) => ($i->price * $i->quantity) * (1 - ($i->discount ?? 0) / 100)), 2) }}
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="7" class="text-end">
                    <a href="{{ route('checkout.index') }}" class="btn btn-success px-4">
                        Proceed to Checkout <i class="fa fa-arrow-right ms-1"></i>
                    </a>
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
    const csrfToken = '{{ csrf_token() }}';

    function updateQuantity(route, newQty, itemId, itemPrice, itemDiscount) {
        fetch(route, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    _method: 'PUT',
                    quantity: newQty
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const discountedPrice = itemPrice * (1 - itemDiscount / 100);
                    const subtotal = discountedPrice * newQty;

                    // Update subtotal
                    const subtotalElement = document.getElementById('subtotal-' + itemId);
                    subtotalElement.innerText = 'Rs ' + subtotal.toFixed(2);

                    // Update grand total
                    updateGrandTotal();
                }
            })
            .catch(err => console.error(err));
    }

    function updateGrandTotal() {
        let total = 0;
        document.querySelectorAll('.quantity-form').forEach(form => {
            const qty = parseInt(form.querySelector('input[name="quantity"]').value);
            const price = parseFloat(form.dataset.price);
            const discount = parseFloat(form.dataset.discount);
            const discountedPrice = price * (1 - discount / 100);
            total += qty * discountedPrice;
        });
        document.getElementById('grand-total').innerText = 'Rs ' + total.toFixed(2);
    }

    document.querySelectorAll('.quantity-form').forEach(form => {
        const input = form.querySelector('input[name="quantity"]');
        const incrementBtn = form.querySelector('.increment');
        const decrementBtn = form.querySelector('.decrement');
        const route = form.dataset.route;
        const itemId = form.dataset.id;
        const itemPrice = parseFloat(form.dataset.price);
        const itemDiscount = parseFloat(form.dataset.discount);

        incrementBtn.addEventListener('click', e => {
            e.preventDefault();
            let qty = parseInt(input.value);
            qty++;
            input.value = qty;
            updateQuantity(route, qty, itemId, itemPrice, itemDiscount);
        });

        decrementBtn.addEventListener('click', e => {
            e.preventDefault();
            let qty = parseInt(input.value);
            if (qty > 1) {
                qty--;
                input.value = qty;
                updateQuantity(route, qty, itemId, itemPrice, itemDiscount);
            }
        });

        input.addEventListener('change', () => {
            let qty = Math.max(1, parseInt(input.value));
            input.value = qty;
            updateQuantity(route, qty, itemId, itemPrice, itemDiscount);
        });
    });
</script>
@endsection