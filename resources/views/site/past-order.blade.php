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
                        @foreach($pastorders as $pastorder)
                            <div class="col-6 media">
                                <img src="{{asset($pastorder->resturant->image)}}" class="mr-3 rounded-circle" alt="res-img" width="30%">
                                <div class="media-body">
                                    <h4>العميل : {{$pastorder->client->name}}</h4>
                                    <div class="restaurant-content">
                                        <h5>رقم الطلب : {{$pastorder->id}}</h5>
                                        <h5>المجموع : {{$pastorder->total_price}} ريال</h5>
                                        <h5>العنوان : {{$pastorder->address}}</h5>
                                    </div>
                                    <!--restaurant-content-->
                                    <div class="button-orders mt-5">
                                        @if($pastorder->state == 'deliverd')
                                            <button class="confirm h6 btn btn-lg px-5">الطلب مكتمل</button>
                                        @else
                                            <button class="refuse h6 btn btn-lg px-5">الطلب تم رفضه بواسطه العميل </button>
                                        @endif

                                    </div>
                                    <!--button-orders-->
                                </div>
                                <!--media-body-->
                            </div>
                            <!--media-->
                        @endforeach
                    </div>
                    <!--tab-pane-->
                </div>
            </section>
                <!--tab-pane-->
        @endsection
