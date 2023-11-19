@extends('admin.layout.sidebar')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Danh sách đơn hàng</h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Customer Email</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Total Amount</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->customer_email }}</td>
                                <td>{{ $order->customer_address }}</td>
                                <td>{{ $order->customer_phone }}</td>
                                <td>{{ '$' . number_format($order->total_price, 2) }}</td>
                                <td>{{ $order->payment_method }}</td>
                                <td>
                                    <form action="{{ route('admin.orders.updateStatus', ['id' => $order->id]) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        @if ($order->status === 'Xác nhận')
                                        <button type="submit" name="status" value="Đang vận chuyển" class="btn btn-info btn-sm">Đang vận chuyển</button>
                                        <button type="submit" name="status" value="Hủy" class="btn btn-danger btn-sm">Hủy</button>
                                        @elseif ($order->status === 'Đã thanh toán')
                                        <!-- Hiển thị thông báo hoặc nội dung thay thế cho trạng thái đã thanh toán -->
                                        Đã thanh toán
                                        @elseif ($order->status === 'Đang vận chuyển')
                                        <button type="submit" name="status" value="Hủy" class="btn btn-danger btn-sm">Hủy</button>
                                        @elseif ($order->status === 'Hủy')
                                        <!-- Hiển thị thông báo hoặc nội dung thay thế cho trạng thái hủy -->
                                        
                                        Đã hủy
                                        @endif
                                    </form>
                                </td>


                                <td>

                                    <a href="{{ route('admin.bills.show', ['id' => $order->id]) }}" class="btn btn-primary btn-sm">View</a>
                                    <!-- ... Các nút sửa và xóa ... -->
                                </td>
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