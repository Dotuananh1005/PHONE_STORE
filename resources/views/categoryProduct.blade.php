@extends('template.layout')
@section('content')
<div class="row">
@foreach($model->products as $pr)
<div class="col-lg-4 col-sm-6">
    
    <div class="product-item">
        <div class="pi-pic">
            <img src="{{ $pr->image?''.Storage::url($pr->image):''}}" alt="" width="500px" height="400px">
            <div class="sale pp-sale">Sale</div>
            <div class="icon">
                <i class="icon_heart_alt"></i>
            </div>
            <ul>
                <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                <li class="quick-view"><a href="#">+ Add Cart</a></li>
                <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
            </ul>
        </div>
        <div class="pi-text">
            <div class="catagory-name">{{$pr->name_category}}</div>
            <a href="{{route('view',['slug'=>$pr->slug])}}">
                <h5>{{$pr->name}}</h5>
            </a>
            <div class="product-price">
            {{$pr->price}} Vnđ
            </div>
        </div>
    </div>
  
</div>
@endforeach
</div>

@endsection
