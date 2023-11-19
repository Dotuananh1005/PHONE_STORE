@extends('template.layout')
@section('content')
<div class="row">
    @foreach($product as $pr)
    <div class="col-lg-4 col-sm-6">

        <div class="product-item">
            <div class="pi-pic">
                <img src="{{ $pr->image?''.Storage::url($pr->image):''}}" alt="" width="500px" height="400px">
                <div class="sale pp-sale">Sale</div>
            </div>
            <div class="pi-text">
                <div class="catagory-name">{{$pr->name_category}}</div>
                <a href="{{route('view',['slug'=>$pr->slug])}}">
                    <h5>{{$pr->name}}</h5>
                </a>
                <div class="product-price">
                    {{$pr->price}} $
                </div>
                <form action="{{ route('cart.add', [ 'product' => $pr->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">+ Add Cart</button>
                </form>

            </div>
        </div>

    </div>
    @endforeach
</div>
@endsection
