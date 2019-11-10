@extends('site/layout/master')
@section('content')
@push('title')
    شراء منتج
    @endpush
    @if(Session::has('cart'))
        <main class="cart" style="padding: 5rem 10rem;">
            <div class="media" id="order1">
                <h4> المبلغ الكلى : {{$total_Price}} ريال</h4>
            </div>
            @foreach($products as $product)
                <div class="media" id="order1">
                    <img src="{{asset($product['product']['image'])}}" class="mr-3"
                         alt="...">
                    <div class="media-body">
                        <h5 class="mt-0">{{$product['product']['name']}} </h5>
                        <h5 class="mt-0">{{$product['product']['price']}} ريال</h5>
                        <h5 class="mt-0">البائع : {{$product['product']['resturant']['name']}}</h5>
                        <h5 class="mt-0">الكمية : <span
                                style="width: 3rem;background-color:#c9c9c9;border: unset">{{$product['amount']}}</span>
                        </h5>
                        <button type="button" class="btn btn-primary btn-lg" id="deleteOrder1">
                            <i class="far fa-times-circle" style="font-size: 1.5rem;"></i>
                            <a style="display: inline" class="h4"
                               href="{{route('reduce',['id' => $product['product']['id']])}}">مسح منتج واحد</a>
                        </button>
                        <button type="button" class="btn btn-primary btn-lg" id="deleteOrder1">
                            <i class="far fa-times-circle" style="font-size: 1.5rem;"></i>
                            <a style="display: inline" class="h4"
                               href="{{route('remove',['id' => $product['product']['id']])}}">مسح</a>
                        </button>
                    </div>
                </div>
            @endforeach
           @if(auth()->guard('web-restaurant')->check())

           @elseif(auth()->guard('web-client')->check())
            <button type="button" class="btn btn-primary btn-lg" id="deleteOrder1" data-toggle="modal" data-target="#exampleModal">
                <i class="fa fa-shopping-cart" style="font-size: 2rem;"></i>
                <a style="display: inline" class="h4"
                   href="{{url('/user/checkout')}}">شراء</a>
            </button>
               @else
                <button type="button" class="btn btn-primary btn-lg" id="deleteOrder1" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-shopping-cart" style="font-size: 2rem;"></i>
                    <a style="display: inline" class="h4"
                       href="#">شراء</a>
                </button>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content text-center">
                            <div class="modal-header">
                                <h4>يرجي تسجيل الدخول؟</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <button type="button" class="btn btn-secondary">
                                <a style="display: inline" class="h2" href="{{url(route('clientlogin'))}}">سجل الان</a>
                            </button>

                        </div>
                    </div>
                </div>
               @endif
        </main>
    @else
        <div class="alert alert-danger text-center">
            <h3>لا توجد منتجات</h3>
        </div>
    @endif


@endsection
