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

        <form action="{{route('route_coupon_edit',['id'=>$coupon->id])}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex">
                <div class="m-5">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="{{$coupon->content}}" class="form-control" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Số lượng</label>
                        <input type="text" value="{{$coupon->count}}" class="form-control" name="count">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Giảm giá</label>
                        <input type="text" value="{{$coupon->value}}" class="form-control" name="value">
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