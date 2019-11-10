@extends('site/layout/master')
@section('content')
    @push('title')
        {{$restaurant->name}}
    @endpush

    <!--================================START RESTAURANT=================================-->
    <section class="restaurant-header text-center text-white">
        <img src="{{asset($restaurant->image)}}" class="rounded-circle" width="250rem">
        <h1> {{$restaurant->name}}</h1>
        <div class="rating">
            @for($i= 1; $i <= 5;$i++)
                <span class="fa fa-star {{$restaurant->reviews()->avg('rate') >= $i?'checked':''}}"></span>
            @endfor
        </div>
        <!--rating-->
    </section>
    <!--================================START RESTAURANT=================================-->



    <!--================================START FOOD=================================-->
    <section class="food text-center">
        <h2>قائمة الطعام / منتجاتى</h2>
        <button type="button" class="btn btn-primary btn-lg">
            <a style="display: inline" href="{{route('getProduct')}}">اضف منتج جديد</a>
        </button>
        <div class="row">
            @foreach($products as $product)
            <div class="col-sm-4" id="food-type1">
                <div class="card" style="width: 100%;">
                    <button class="btnDelete" id="btnDelete1"><i class="fas fa-times-circle"></i></button>
                    <img src="{{asset($product->image)}}" class="card-img-top " alt="...">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <p class="small">{{$product->ingredients}}</p>
                        <p class="card-text text-left ml-5 h5">
                            <img src="{{asset('web/img/images/pig.png')}}" width="40rem">
                            {{$product->price}} ريال
                        </p>
                        <button type="button" class="btn btn-primary btn-lg m-2">
                            <a href="{{url(route('mealDetail',$product->id))}}"> إضغط هنا للتفاصيل </a>
                        </button>
                        <button type="button" class="btn btn-primary btn-lg m-2">
                            <a href="{{url(route('getEditProduct',$product->id))}}"> تعديل </a>
                        </button>
                        <button type="button" class="btn btn-primary btn-lg m-2">
                            <a href="{{url(route('deleteProduct',$product->id))}}">  حذف </a>
                        </button>
                    </div>
                </div>
            </div>
       @endforeach
            <!--col-->
        </div>
        <!--row-->
    </section>
    <!--================================END FOOD=================================-->

@endsection




