@extends('admin.layout.sidebar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng cộng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders['product'] as $product)
                            <tr>

                                <td><img src="{{ $product['product']['image'] ? ''.Storage::url($product['product']['image']) : '' }}" alt="" height="80px"></td>
                                <td>{{ $product['product']['name'] }}</td>
                                <td>{{ $product['product']['price'] }}</td>
                                <td>{{ $product['quantity'] }}</td>
                                <td>{{ $product['total_price'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection