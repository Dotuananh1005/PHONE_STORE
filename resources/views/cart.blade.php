@extends('template.layout')

@section('content')
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cart-table">
                        <table>
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th class="p-name">Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cartItems as $cartItem)
                                <tr class="cart" id="cart-{{$cartItem->id}}">
                                    <td class="cart-pic first-row">
                                        <img
                                            src="{{ $cartItem->product->image ? ''.Storage::url($cartItem->product->image) : '' }}"
                                            alt="" width="200px">
                                    </td>
                                    <td class="cart-title first-row">
                                        <h5>{{ $cartItem->product->name }}</h5>
                                    </td>
                                    <td class="p-price first-row">
                                        <span id="unit-price-{{$cartItem->id}}"
                                              price="{{$cartItem->price}}">{{ '$' . number_format($cartItem->price, 2) }}</span>
                                    </td>
                                    <td class="qua-col first-row">
                                        <div>
                                            <input id="quantity-{{ $cartItem->id }}" type="number" min="1" max="100"
                                                   value="{{ $cartItem->quantity }}" style="text-align: center;"
                                                   price="{{ $cartItem->price }}"
                                                   class="quantity-input">
                                        </div>
                                    </td>
                                    <td class="size-col">
                                        <div class="form-group pt-5">
                                            <select id="size-{{ $cartItem->id }}" name="size" class="form-control size-input"
                                                    price="{{ $cartItem->price }}"
                                                    required>
                                                @foreach($productSize as $size)
                                                    <option
                                                        value="{{$size->id}}"
                                                        {{ $cartItem->product_size_id === $size->id ? 'selected' : '' }}>
                                                        {{$size->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td class="cart-price first-row" id="cart-price-{{ $cartItem->id }}"
                                        price="{{$cartItem->total_price}}">
                                        {{ '$' . number_format($cartItem->total_price, 2) }}
                                    </td>
                                    <td class="close-td first-row">
                                        <a href="{{ route('cart.remove', ['id' => $cartItem->id]) }}">
                                            <i class="ti-close"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 offset-lg-8">
                            <div class="proceed-checkout">
                                <ul>
                                    <li class="cart-total">Total <span
                                            id="cart-total">{{ '$' . number_format($totalPrice, 2) }}</span></li>
                                </ul>
                                <a href="{{ route('route_bill') }}" class="proceed-btn">PROCEED TO CHECKOUT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(function () {
            const updateCart = (_this) => {
                const cartEleId = $(_this).closest('.cart').attr('id')
                const cartId = cartEleId.split('-')[1]
                const unitPrice = $(`#unit-price-${cartId}`).attr('price')
                const quantity = $(`#quantity-${cartId}`).val()

                $(`#cart-price-${cartId}`).text('$' + new Intl.NumberFormat('en-US').format(unitPrice * quantity)).attr('price', unitPrice * quantity)
                let totalPrice = 0
                $('.cart-price').each(function () {
                    totalPrice += parseFloat($(this).attr('price'))
                })
                $(`#cart-total`).text('$' + new Intl.NumberFormat('en-US').format(totalPrice))
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/update-cart",
                    method: 'post',
                    data: {
                        'cart_product_id': cartId,
                        'product_size_id': $(`#size-${cartId}`).val(),
                        'quantity': quantity,
                    },
                    success: function (html) {

                    },
                    error: function(response) {
                        alert(response.message)
                    }
                });
            }
            $(document).on('change', '.quantity-input', function () {
                updateCart(this)
            })
            $(document).on('change', '.size-input', function () {
                updateCart(this)
            })
        })
    </script>
@endsection
