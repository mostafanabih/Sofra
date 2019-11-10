@extends('site/layout/master')
@section('content')
    @push('title')
        طلباتي
    @endpush
    <section class="orders">

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link"  href="{{route('myOrders')}}"  aria-controls="nav-all" aria-selected="true">
                    <h3>طلبات جديدة</h3>
                </a>
                <a class="nav-item nav-link"   href="{{route('currentOrder')}}"  aria-controls="nav-mens" aria-selected="true">
                    <h3>طلبات حالية</h3>
                </a>
                <a class="nav-item nav-link"  href="{{route('pastOrder')}}"  aria-controls="nav-womens" aria-selected="false">
                    <h3>طلبات سابقة</h3>
                </a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">

        <div>
    @foreach($currentorders as $currentorder)
        <div class="col-6 media">
            <img src="{{asset($currentorder->resturant->image)}}" class="mr-3 rounded-circle" alt="res-img" width="30%">
            <div class="media-body">
                <h4>العميل : {{$currentorder->client->name}}</h4>
                <div class="restaurant-content">
                    <h5>رقم الطلب : {{$currentorder->id}}</h5>
                    <h5>المجموع : {{$currentorder->total_price}} ريال</h5>
                    <h5>العنوان : {{$currentorder->address}}</h5>
                </div>
                <!--restaurant-content-->
                <div class="button-orders mt-5">
                    <button class="phone h6 btn btn-lg px-5">{{$currentorder->client->phone}}</button>
                    <button class="confirm h6 btn btn-lg px-5"><a href="{{route('deliverOrder',$currentorder->id)}}">تأكيد التسليم</a></button>
                </div>
                <!--button-orders-->
            </div>
            <!--media-body-->
        </div>
        <!--media-->
    @endforeach

</div>
        </div>
<!--tab-pane-->
    </section>
    @endsection
