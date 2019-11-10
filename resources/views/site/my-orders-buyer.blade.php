@extends('site/layout/master')
@section('content')
    @push('title')
        طلباتي
    @endpush

    <section class="orders-buyer">

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link" style="margin-left: 10rem"  href="{{route('clientCurrentOrder')}}"  aria-controls="nav-all" aria-selected="true">
                    <h3>طلبات جديدة</h3>
                </a>
                <a class="nav-item nav-link"  aria-controls="nav-womens" href="{{route('clientPastOrder')}}" aria-selected="false">
                    <h3>طلبات سابقة</h3>
                </a>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">


            <div>
                @foreach($clientorders as $clientorder)

                <div class="col-6 media">
                    <img src="{{asset($clientorder->resturant->image)}}" class="mr-3 rounded-circle" alt="res-img" width="30%">
                    <div class="media-body row">
                        <div class="restaurant-content col-9">
                           @foreach($clientorder->products as $product) <h4>{{$product->name}}</h4>
                        @endforeach
                            <h5>رقم الطلب : {{$clientorder->id}}</h5>
                            <h5>المجموع : {{$clientorder->total_price}} ريال</h5>
                        </div>
                        <!--restaurant-content-->
                        <div class="button-orders col" style="display: grid">
                            <button class="confirm h6 btn btn-lg"><a href="{{route('deliverdOrder',$clientorder->id)}}">استلام</a></button>
                            <button class="refuse h6 btn btn-lg"><a href="{{route('decliendOrder',$clientorder->id)}}">رفض</a></button>
                        </div>
                        <!--button-orders-->
                    </div>
                    <!--media-body-->
                </div>
                <!--media-->

            </div>
            <!--tab-pane-->
            @endforeach
        </div>
        <!--tab-content-->

    </section>
@endsection
