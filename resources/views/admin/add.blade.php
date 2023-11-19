@extends('admin.layout.sidebar')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
<style>
    .custom-form {
        max-width: 800px;
        /* Điều chỉnh kích cỡ theo ý muốn */
    }
</style>


<div class="container d-flex align-items-center justify-content-center vh-50">
    <div class="custom-form">
        <h1 class="text-center">Thêm sản phẩm</h1>

        <form action="{{route('route_product_add')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex">
                <div class="m-5">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Giá Nhập</label>
                        <input type="number" class="form-control" name="price_import">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Giá Bán</label>
                        <input type="number" class="form-control" name="price">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Số lượng</label>
                        <input type="number" class="form-control" name="quantity">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Thông Tin</label>
                        <input type="text" class="form-control" name="information">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Slug</label>
                        <input type="text" class="form-control" name="slug">
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-sm-4 control-label">ẢnhQuầnÁo</label>
                        <div class="col-md-9 col-sm-8">
                            <div class="row">
                                <div class="col-xs-6">
                                    <img id="mat_truoc_preview" src="https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg" alt="your image" style="max-width: 200px; height:100px; margin-bottom: 10px;" class="img-fluid" />
                                    <input type="file" name="image" accept="image/*" class="form-control-file @error('image') is-invalid @enderror" id="cmt_truoc">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Ngày Nhập Hàng</label>
                        <input type="date" class="form-control" name="date">
                    </div>
                    <div class="mb-3">
                    <div class="mb-3">
                        <label for="name" class="form-label">Danh mục</label>
                        <select class="form-select" name="category_id">
                            @foreach($category as $cate)
                            <option value="{{$cate->id}}"> {{$cate->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </div>

        </form>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(function(){
            function readURL(input, selector) {
                if (input.files && input.files[0]) {
                    let reader = new FileReader();

                    reader.onload = function (e) {
                        $(selector).attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#cmt_truoc").change(function () {
                readURL(this, '#mat_truoc_preview');
            });

        });
    </script>
@endsection
