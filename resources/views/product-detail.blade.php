@extends('template.layout')
@section('content')
<div class="container mt-5">
  <div class="row">
    <div class="col-lg-6">
      <img src="{{ $model->image?''.Storage::url($model->image):''}}" alt="Đồng hồ đeo tay" class="img-fluid">
    </div>
    <div class="col-lg-6">
      <h1>{{$model->name}}</h1>
      <p class="text-muted"></p>
      <p>Giá: {{$model->price}}VNĐ</p>
      <p>Mô tả ngắn: {{$model->information}}</p>
      <p>Hàng Việt Nam chất lượng cao tin dùng đến mọi nhà.</p>
      <form action="{{ route('cart.add2',[ 'model' => $model->id]) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
      </form>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col">
      <h2>Thông số kỹ thuật:</h2>
      <ul>
        <li>Chất liệu: Vải lụa </li>
        <li>Kích thước: Size M </li>
        <li>Trọng lượng: 0,5 kg </li>
        <!-- Thêm các thông số khác nếu cần -->
      </ul>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col">
      <h2>Đánh giá sản phẩm:</h2>
      <div class="media">
        <img src="{{ $model->image?''.Storage::url($model->image):''}}" alt="Người đánh giá" class="mr-3" style="width:60px;">
        <div class="media-body">
          <h5 class="mt-0">Người đánh giá</h5>
          <p>Sản phẩm rất đẹp</p>
        </div>
      </div>
      <!-- Thêm các đánh giá khác nếu có -->
    </div>
  </div>
</div>

<!-- Đoạn mã JavaScript Bootstrap (bao gồm jQuery) -->

@endsection