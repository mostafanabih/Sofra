@extends('site/layout/master')
@inject('city','App\Models\City')
@section('content')
    @push('title')
        المطاعم
    @endpush
    <main>

        <!--================================START RESTAURANT===============================-->
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
                                 'id' => 'inputGroupSelect01'
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






                <div class="row mt-4">

                    @foreach($rules as $rule)
                        <div class="col-md-6">
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
                <!--row-->
            </div>
            <!--container-->
        </section>

        <!--================================END RESTAURANT=================================-->



    </main>

@endsection
