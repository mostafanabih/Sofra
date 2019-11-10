@extends('site/layout/master')
@section('content')
    @push('title')
            مطعم {{$detail->name}}
    @endpush


    <!--================================START RESTAURANT=================================-->
    <section class="restaurant-header text-center text-white">
        <img src="{{asset($detail->image)}}" class="rounded-circle" width="300rem">
        <h1> {{$detail->name}}</h1>
        <div class="rating">
            @for($i= 1; $i <= 5;$i++)
                <span class="fa fa-star {{$detail->reviews()->avg('rate') >= $i?'checked':''}}"></span>
            @endfor
        </div>
        <!--rating-->
    </section>
    <div class="row">
    <div class="food col-md-6">
        <h5 style="color:black; margin-bottom: 30px;"><i class="fa fa-mail-bulk"></i>البريد الإلكتروني : {{$detail->email}} </h5>
        <h5 style="color:black; margin-bottom: 30px;"><i class="fa fa-phone"></i> الهاتف : {{$detail->phone}} </h5>
        <h5 style="color:black; margin-bottom: 30px;"><i class="fa fa-home"></i> الحي : {{$detail->neighborhood->name}} </h5>
        <h5 style="color:black; margin-bottom: 30px;"><i class="fa fa-bars"></i>   التصنيفات : @foreach($detail->categories as $category)
                {{$category->name}}
            @endforeach </h5>
        <h5 style="color:black; margin-bottom: 30px;"><i class="fa fa-money-bill"></i> رسوم التوصيل : {{$detail->delivery_fees}}ريال </h5>
        <h5 style="color:black; margin-bottom: 30px;"><i class="fa fa-sort-numeric-down"></i> الحد الادني : {{$detail->minimum}} </h5>
    </div>
    <div class="food col-md-6">
        <h5 style="color:black; margin-bottom: 30px;"><i class="fa fa-star"></i> الوضع : {{$detail->state}} </h5>
        <h5 style="color:black; margin-bottom: 30px;"><i class="fa fa-star"></i> الحاله : {{$detail->status}} </h5>
        <h5 style="color:black; margin-bottom: 30px;">بيانات التوصيل :</h5>
        <h5 style="color:black; margin-bottom: 30px;"><i class="fa fa-phone"></i>  الواتس  : {{$detail->whats_app}} </h5>
        <h5 style="color:black; margin-bottom: 30px;"><i class="fa fa-phone-square"></i> الهاتف : {{$detail->contact_phone}} </h5>
    </div>
    </div>
    <!--================================START RESTAURANT=================================-->



    <!--================================START FOOD=================================-->
    <section class="food">

          <div class="row">
              @foreach($products as $product)
            <div class="col-sm-4">

                <div class="card" style="width: 100%;">
                    <img src="{{asset($product->image)}}" class="card-img-top" alt="...">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <p class="small">{{$product->ingredients}}</p>
                        <p class="card-text text-left ml-5 h5">
                            <img src="{{asset('web/img/images/food-order.png')}}" width="10%">
                            {{$product->order_process_time}} دقيقة تقريباً
                        </p>
                        <p class="card-text text-left ml-5 h5">
                            <img src="{{asset('web/img/images/pig.png')}}" width="10%">
                            {{$product->price}} ريال
                        </p>
                        <button type="button" class="btn btn-primary btn-lg m-2">
                            <a href="{{url(route('mealDetail',$product->id))}}"> اضغط هنا للتفاصيل</a>
                        </button>
                    </div>
                </div>
            </div>
              @endforeach

          </div>


    </section>
    <!--================================END FOOD=================================-->


@endsection
