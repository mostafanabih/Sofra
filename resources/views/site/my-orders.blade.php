@extends('site/layout/master')
@section('content')
    @push('title')
        طلباتي
    @endpush



    <section class="orders">

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link"  href="{{route('myOrders')}}" role="tab" aria-controls="nav-all" aria-selected="true">
                    <h3>طلبات جديدة</h3>
                </a>
                <a class="nav-item nav-link"  href="{{route('currentOrder')}}" role="tab" aria-controls="nav-mens" aria-selected="true">
                    <h3>طلبات حالية</h3>
                </a>
                <a class="nav-item nav-link"  href="{{route('pastOrder')}}" role="tab" aria-controls="nav-womens" aria-selected="false">
                    <h3>طلبات سابقة</h3>
                </a>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">


            <div class="tab-pane fade show active"  role="tabpanel" aria-labelledby="nav-new-tab">
          @foreach($neworders as $neworder)
                <div class="col-6 media">
                    <img src="{{asset($neworder->resturant->image)}}" class="mr-3 rounded-circle" alt="res-img" width="30%">
                    <div class="media-body">
                        <h4>العميل : {{$neworder->client->name}}</h4>
                        <div class="restaurant-content">
                            <h5>رقم الطلب : {{$neworder->id}}</h5>
                            <h5>المجموع : {{$neworder->total_price}} ريال</h5>
                            <h5>العنوان : {{$neworder->address}}</h5>
                        </div>
                        <!--restaurant-content-->
                        <div class="button-orders mt-5">
                            <button class="phone h6 btn btn-lg px-5">{{$neworder->client->phone}}</button>
                            <button type="submit" class="confirm h6 btn btn-lg px-5"><a href="{{route('acceptOrder',$neworder->id)}}">استلام</a></button>
                            <button class="refuse h6 btn btn-lg px-5"><a href="{{route('rejectOrder',$neworder->id)}}">رفض</a></button>
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
        <!--tab-content-->

    </section>




@endsection
