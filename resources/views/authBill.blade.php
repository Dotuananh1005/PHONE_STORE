@extends('template.layout') <!-- Tùy theo cách bạn tổ chức layout -->

@section('content')
<div class="container">
    <h1>Hóa đơn</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Ngày mua</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Sản phẩm</th>
                <!-- Thêm các cột khác tùy theo nhu cầu -->
            </tr>
        </thead>
        <tbody>
            @foreach ($bills as $bill)
            <tr>
                <td>{{ $bill['date'] }}</td>
                <td>${{ $bill['total_price'] }}</td>
                <td>{{ $bill['status'] }}</td>
                <td>
                    @foreach ($bill['product'] as $product)
                    @dd($bill)
                    {{ $product['product']['name'] }},Giá: {{ $product['product']['price'] }}, Số lượng: {{ $product['quantity'] }}, Ảnh:<img src="{{ $product['product']['image'] ? ''.Storage::url($product['product']['image']) : '' }}" alt="" height="80px">
                    <br>
                    @endforeach
                </td> <!-- Thêm các ô khác tùy theo nhu cầu -->
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection