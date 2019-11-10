
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

@foreach($clientpasts as $clientpast)
<div>


    <div class="col-6 media">
        <img src="{{asset($clientpast->resturant->image)}}" class="mr-3 rounded-circle" alt="res-img" width="30%">
        <div class="media-body">
            @foreach($clientpast->products as $product) <h4>{{$product->name}}</h4>
            @endforeach
            <div class="restaurant-content">
                <h5>رقم الطلب : {{$clientpast->id}}</h5>
                @foreach($clientpast->products as $product)<h5>السعر : {{$product->pivot->price}} ريال</h5> @endforeach
                <h5>التوصيل : {{$clientpast->delivery_fees}} ريال</h5>
                <h5>الاجمالى : {{$clientpast->total_price}} ريال</h5>

            </div>
            <!--restaurant-content-->
                <div class="button-orders col" style="display: grid">
                    @if($clientpast->state == 'deliverd')
                    <button class="confirm h6 btn btn-lg">الطلب تم استلامه</button>
                    @elseif($clientpast->state == 'declined')
                    <button class="refuse h6 btn btn-lg">الطلب تم رفضه بواسطتك</button>
                    @elseif($clientpast->state == 'rejected')
                    <button class="refuse h6 btn btn-lg">الطلب تم رفضه بواسطه المطعم  </button>
                        @else

                    @endif
                </div>
        </div>
        <!--media-body-->
    </div>
    <!--media-->

</div>
<!--tab-pane-->
    @endforeach
        </div>
    </section>
    @endsection
