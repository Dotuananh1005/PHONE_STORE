@extends('template.layout')

@section('content')
<section class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Size</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $cartItem)
                            <tr>
                                <td class="cart-pic">
                                    <img src="{{ $cartItem->product->image ? ''.Storage::url($cartItem->product->image) : '' }}" alt="">
                                </td>
                                <td class="cart-title">
                                    <h5>{{ $cartItem->product->name }}</h5>
                                </td>
                                <td class="p-price">
                                    {{ '$' . number_format($cartItem->price, 2) }}
                                </td>
                                <td class="qua-col">
                                    {{ $cartItem->quantity }}
                                </td>
                                <td class="qua-col">
                                    {{ $cartItem->productSize->name }}
                                </td>
                                <td class="total-price total-{{ $cartItem->id }}">
                                    {{ '$' . number_format($cartItem->total_price, 2) }}
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="cart-pic" colspan="5" style="text-align: right">
                                    Giảm giá:
                                </td>
                                <td class="cart-pic" id="sale" style="text-align: right">

                                </td>
                            </tr>
                            <tr>
                                <td class="cart-pic" colspan="5" style="text-align: right">
                                    Tổng tiền:
                                </td>
                                <td class="cart-pic last-price" price="{{ $totalPrice }}" style="text-align: right">
                                    {{ '$' . number_format($totalPrice, 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <h4>Thông tin người mua hàng</h4>
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="address">Họ và Tên:</label>
                        <input type="text" id="name" name="customer_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Email:</label>
                        <input type="email" id="email" name="customer_email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ:</label>
                        <input type="text" id="address" name="customer_address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="tel" id="phone" name="customer_phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="payment_method">Phương thức thanh toán:</label>
                        <select id="payment_method" name="payment_method" class="form-control" required>
                            <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <input id="coupon" type="text" class="form-control" placeholder="Mã giảm giá" name="coupon" aria-label="Mã giảm giá" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="coupon-btn">Áp dụng</button>
                        </div>
                    </div>
                    <div class="proceed-checkout">
                        <ul>
                            <li class="cart-total">Total
                                <span id="cart-total" class="last-price" price="{{ $totalPrice }}">{{ '$' . number_format($totalPrice, 2) }}</span>
                            </li>
                        </ul>
                    </div>
                    <button type="submit" class="btn btn-primary">Xác nhận đơn hàng</button>
                </form>

            </div>
        </div>
    </div>
</section>
<script>
    $(function() {
        $(document).on('click', '#coupon-btn', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/apply-coupon",
                method: 'post',
                data: {
                    'content': $('#coupon').val(),
                },
                success: function(response) {
                    if (response.status === 200) {
                        $('.last-price').each(function() {
                            const price = parseFloat($(this).attr('price'))
                            $(this).text('$' + new Intl.NumberFormat('en-US').format(price - price * response.data))
                        })

                        $('#sale').text(`${response.data * 100}%`)
                    }
                    alert(response.message)
                },
                error: function(response) {
                    console.log(response)
                    // alert(response.message)
                }
            });
        })
    })
</script>
@endsection