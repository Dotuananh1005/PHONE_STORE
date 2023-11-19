@extends('admin.layout.sidebar')
@section('content')
<div>
    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Quản Lí Quần Áo</h1>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <button type="button" class="btn btn-primary" style="margin-bottom:15px ;">
                    <a href="{{route('route_product_add')}}" class="text-white text-decoration-none"> Thêm mới Quần Áo </a>
                </button>

                <!-- Modal -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá Nhập</th>
                                <th>Giá bán</th>
                                <th>Loại</th>
                                <th>Thông Tin</th>
                                <th>Ngày nhập hàng</th>
                                <th>Số Lượng</th>
                                <th>Trạng Thái</th>
                                <th>Ảnh</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá Nhập</th>
                                <th>Giá bán</th>
                                <th>Loại</th>
                                <th>Thông Tin</th>
                                <th>Ngày nhập hàng</th>
                                <th>Số Lượng</th>
                                <th>Trạng Thái</th>
                                <th>Ảnh</th>
                                <th>Hành động</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($product as $pr)
                            <tr>
                                <td>{{$pr->id}}</td>
                                <td>{{$pr->name}}</td>
                                <td>{{$pr->price_import}}</td>
                                <td>{{$pr->price}}</td>
                                <td>{{$pr->name_category}}</td>
                                <td>{{$pr->information}}</td>
                                <td>{{$pr->date}}</td>
                                <td>{{$pr->quantity}}</td>
                                <td>{{ __("common.product.status.{$pr->status}") }}</td>
                                <td><img src="{{ $pr->image?''.Storage::url($pr->image):''}}" alt="" width="100px"></td>
                                <td class="d-flex"><a href="{{route('route_product_edit',['id'=>$pr->id])}}" class="btn btn-primary m-2">Sửa</a>
                                    <a class="btn btn-danger m-2" href="{{ route('route_product_delete',['id'=>$pr->id]) }}">Xóa</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Footer -->

@endsection
