@extends('site/layout/master')
@section('content')
    @push('title')
        الوجبات
    @endpush


    <section class="meal container">

        <img src="{{asset($products->image)}}" class="meal-photo">
        <h1>{{$products->name}}</h1>
        <h6>{{$products->ingredients}}</h6>
        <div class="meal-details">
            <h5><img src="{{asset('web/img/images/Layer 5.png')}}"> السعر : {{$products->price}} ريال</h5>
            <h5><img src="{{asset('web/img/images/Layer 2.png')}}">مدة تجهيز الطلب : {{$products->order_process_time}} دقيقة</h5>
            <h5><img src="{{asset('web/img/images/Layer 3.png')}}">السعر في العرض : {{$products->price_on_offer}} ريال</h5>
        </div>
        <!--meal-details-->
        <hr>

        <button type="submit" class="btn btn-primary btn-lg" >
            <a href="{{route('add-to-cart',$products->id)}}"> <h2 style="display: inline">أضف إلى العربة</h2></a>
        </button>




        <div class="meal-info">
            <h5><img src="{{asset('web/img/images/Layer 4.png')}}" width="7%"><a href="{{route('restaurantDetail',$products->resturant_id)}}">معلومات عن هذا المتجر</a></h5>
            <h3 class="border-l">تقييمات المستخدمين</h3>
            <p class="sm ml-3">155 تقييم</p>
        </div>
        <!--meal-info-->

        <div class="reviews">
     @foreach($reviews as $review)
            <div class="review">
                <span style="color: black;">بواسطه : {{$review->client->name}}</span>
                <div class="rating" style="display: inline-block">
                    {!! str_repeat('<span class="fa fa-star " style="color: crimson;"></span>',$review->rate)  !!}
                    {!! str_repeat('<span class="fa fa-star " style="color: grey;"></span>',5-$review->rate)  !!}

                </div>
                <!--rating-->

                <h5 style="color: black;" class="mt-5 mb-3">{{$review->comment}}</h5>
            </div>
            @endforeach
            <!--review-->

        </div>
        <!--reviews-->
@if (auth()->guard('web-restaurant')->check())

    @elseif(auth()->guard('web-client')->check())
        <div class="review-write my-5">
            <h4 class="border-l">أضف تقييمك</h4>
            <div class="rating">
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
            </div>
            <!--rating-->
            <textarea rows="6" placeholder="أضف تقييمك"></textarea>
            <button type="button" class="btn btn-primary btn-lg">
                <h2 style="display: inline">إرسال</h2>
            </button>
        </div>
        @else

    @endif
        <!--review-write-->

        <div class="more-food" style="direction: ltr">
            <h4 class="border-l text-left">المزيد من أكلات هذا المطعم</h4>
            <div class="bg">
                <div class="container">
                    <div class="owl-carousel owl-theme" id="owl-services">
                        @foreach($foods as $food)
                        <div class="item">
                            <img src="{{asset($food->image)}}">
                            <div class="overlay"></div>
                            <div class="button">
                                <h4>{{$food->name}}</h4>
                                <a href="{{url(route('mealDetail',$food->id))}}"> اضغط للتفاصيل </a>
                            </div>
                        </div>
                            @endforeach



                    </div>
                    <!--owl-carousel-->
                </div>
                <!--container-->
            </div>
            <!--bg-->
        </div>
        <!--more-food-->




    </section>

@endsection
