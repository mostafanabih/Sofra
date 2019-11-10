@extends('site/layout/master')
@inject('city','App\Models\City')

    @push('title')
        الرئيسيه
    @endpush
@section('content')


    <main>


        <!--================================START HEADER===============================-->
        <header>
            <h1 class="main-heading">سُفرة</h1>
            <h1 class="sub-heading">بتشترى .. بتبيع ؟ كله عند أم ربيع</h1>
            @if(auth()->guard('web-client')->check())

            @elseif(auth()->guard('web-restaurant')->check())

                @else
            <button type="button" class="btn btn-primary btn-lg">
                <a style="display: inline" class="h2" href="{{url(route('clientlogin'))}}">طلب طعام</a>
                <img src="{{asset('web/img/images/dish.png')}}" class="ml-1" width="20%">
            </button>
            <button type="button" class="btn btn-primary btn-lg">
                <a style="display: inline" class="h2" href="{{url(route('restaurantlogin'))}}">بيع طعام</a>
                <img src="{{asset('web/img/images/dish.png')}}" class="ml-1" width="20%">
            </button>
            @endif
        </header>
        <!--================================END HEADER=================================-->



        <!--================================START RESTAURANT===============================-->
        @if(auth()->guard('web-restaurant')->check())

            @elseif(auth()->guard('web-client')->check())
        <section class="restaurant">
            <div class="container">
                <h2>ابحث عن مطعمك المفضل</h2>
                {!! Form::open([
                     'action' => ['Front\MainController@searchrestaurant'],
                     'method' => 'get'
                 ]) !!}
                <div class="row mt-5">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            {!!Form::select('city_id',$city->get()->pluck('name','id')->toArray(),null,[
                                'class' => 'custom-select',
                                 'placeholder'=>'المدينه',
                                 'id' => 'cities'
                            ])!!}
                        </div>

                    </div>

                    <!--col-->
                    <div class="col-md-6">
                        <div class="search_box mb-3">
                            <input type="search"  name="keyword" class="form-control mr-sm-2" placeholder="ابحث عن مطعمك المفضل">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                    <!--col-->
                </div>
                <!--row-->
                {!! Form::close() !!}






                <div class="row mt-4" >

                  @foreach($rules as $rule)
                    <div class="col-md-6" >
                        <div class="media">
                            <img src="{{asset($rule->image)}}" class="mr-3 rounded-circle"  alt="res-img" width="30%">
                            <div class="media-body">
                               <a href="{{route('restaurantDetail',$rule->id)}}"> <h4>{{$rule->name}} </h4></a>
                                @for($i= 1; $i <= 5;$i++)
                                    <span class="fa fa-star {{$rule->reviews()->avg('rate') >= $i?'checked':''}}"></span>
                                @endfor
                                <!--rating-->
                                <div class="restaurant-content">
                                    @if ($rule->state == 'open')
                                    <h5 class="open">
                                        <i class="fas fa-circle mr-2" style="color: #17bf4e;"></i>
                                        مفتوح</h5>
                                    @else
                                        <h5 class="open">
                                        <i class="fas fa-circle mr-2" style="color: #1b1613;"></i>
                                        مغلق</h5>
                                    @endif
                                    <p class="mt-3">الحد الأدنى للطلب : {{$rule->minimum}} ريال</p>
                                    <p>رسوم التوصيل : {{$rule->delivery_fees}} ريال</p>
                                </div>
                                <!--restaurant-content-->
                            </div>
                            <!--media-body-->
                        </div>
                        <!--media-->
                    </div>
                    <!--col-->
                    @endforeach

                </div>

                <a href="{{url(route('allRestaurants'))}}"><button class="btn btn-dark btn-lg col-sm-3">المزيد  </button></a>
                <!--row-->
            </div>
            <!--container-->
        </section>
        @else
            <section class="restaurant">
                <div class="container">
                    <h2>ابحث عن مطعمك المفضل</h2>
                    {!! Form::open([
                         'action' => ['Front\MainController@searchrestaurant'],
                         'method' => 'get'
                     ]) !!}
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                {!!Form::select('city_id',$city->get()->pluck('name','id')->toArray(),null,[
                                    'class' => 'custom-select',
                                     'placeholder'=>'المدينه',
                                     'id' => 'cities'
                                ])!!}
                            </div>

                        </div>

                        <!--col-->
                        <div class="col-md-6">
                            <div class="search_box mb-3">
                                <input type="search"  name="keyword" class="form-control mr-sm-2" placeholder="ابحث عن مطعمك المفضل">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                    {!! Form::close() !!}






                    <div class="row mt-4" >

                        @foreach($rules as $rule)
                            <div class="col-md-6" >
                                <div class="media">
                                    <img src="{{asset($rule->image)}}"  class="mr-3 rounded-circle"  alt="res-img" width="30%">
                                    <div class="media-body">
                                        <a href="{{route('restaurantDetail',$rule->id)}}"> <h4>{{$rule->name}} </h4></a>
                                        @for($i= 1; $i <= 5;$i++)
                                            <span class="fa fa-star {{$rule->reviews()->avg('rate') >= $i?'checked':''}}"></span>
                                    @endfor
                                    <!--rating-->
                                        <div class="restaurant-content">
                                            @if ($rule->state == 'open')
                                                <h5 class="open">
                                                    <i class="fas fa-circle mr-2" style="color: #17bf4e;"></i>
                                                    مفتوح</h5>
                                            @else
                                                <h5 class="open">
                                                    <i class="fas fa-circle mr-2" style="color: #1b1613;"></i>
                                                    مغلق</h5>
                                            @endif
                                            <p class="mt-3">الحد الأدنى للطلب : {{$rule->minimum}} ريال</p>
                                            <p>رسوم التوصيل : {{$rule->delivery_fees}} ريال</p>
                                        </div>
                                        <!--restaurant-content-->
                                    </div>
                                    <!--media-body-->
                                </div>
                                <!--media-->
                            </div>
                            <!--col-->
                        @endforeach

                    </div>

                    <a href="{{url(route('allRestaurants'))}}"><button class="btn btn-dark btn-lg col-sm-3">المزيد  </button></a>
                    <!--row-->
                </div>
                <!--container-->
            </section>
        @endif


        <!--================================END RESTAURANT=================================-->



        <!--================================START OFFERS===============================-->
        @if(auth()->guard('web-restaurant')->check())
            <section class="offers">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="{{asset('web/img/images/offers.png')}}" width="100%">
                        </div>
                        <!--col-->
                        <div class="col-md-7">
                            <div class="bg text-center">
                                <h2 class="paragraph">نقدم فى سفرة أفضل العروض لكل أنواع المطاعم و الأكلات الشهية المهلبية ماذا تنتظر إبدأ الإستمتاع بالعروض الآن</h2>
                                <button type="button" class="btn btn-primary btn-lg">
                                    <a style="display: inline" class="h2" href="{{url(route('restaurantOffer'))}}">شاهد العروض</a>
                                </button>
                            </div>
                            <!--bg-->
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                </div>
                <!--container-->
            </section>
        @elseif(auth()->guard('web-client')->check())
        <section class="offers">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <img src="{{asset('web/img/images/offers.png')}}" width="100%">
                    </div>
                    <!--col-->
                    <div class="col-md-7">
                        <div class="bg text-center">
                            <h2 class="paragraph">نقدم فى سفرة أفضل العروض لكل أنواع المطاعم و الأكلات الشهية المهلبية ماذا تنتظر إبدأ الإستمتاع بالعروض الآن</h2>
                            <button type="button" class="btn btn-primary btn-lg">
                                <a style="display: inline" class="h2" href="{{url(route('offers'))}}">شاهد العروض</a>
                            </button>
                        </div>
                        <!--bg-->
                    </div>
                    <!--col-->
                </div>
                <!--row-->
            </div>
            <!--container-->
        </section>
            @else
                <section class="offers">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5">
                                <img src="{{asset('web/img/images/offers.png')}}" width="100%">
                            </div>
                            <!--col-->
                            <div class="col-md-7">
                                <div class="bg text-center">
                                    <h2 class="paragraph">نقدم فى سفرة أفضل العروض لكل أنواع المطاعم و الأكلات الشهية المهلبية ماذا تنتظر إبدأ الإستمتاع بالعروض الآن</h2>
                                    <button type="button" class="btn btn-primary btn-lg">
                                        <a style="display: inline" class="h2" href="{{url(route('offers'))}}">شاهد العروض</a>
                                    </button>
                                </div>
                                <!--bg-->
                            </div>
                            <!--col-->
                        </div>
                        <!--row-->
                    </div>
                    <!--container-->
                </section>
            @endif
        <!--================================END OFFERS=================================-->



        <!--================================START APP===============================-->
        <section class="app">
            <div class="row">
                <div class="col-md-7">
                    <h1>قم بتحميل التطبيق الخاص بنا الآن</h1>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary btn-lg">
                            <h1>حمل الآن <i class="fab fa-android"></i></h1>
                        </button>
                    </div>
                </div>
                <!--col-->
                <div class="col-md-5 mb-0 pb-0">
                    <img src="{{asset('web/img/images/app mockup.png')}}" width="100%">
                </div>
                <!--col-->
            </div>
            <!--row-->
        </section>
        <!--================================END APP===============================-->



    </main>
@endsection



