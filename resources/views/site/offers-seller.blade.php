
@extends('site/layout/master')
@section('content')
    @push('title')
        عروضي
    @endpush


    <main>

        <section class="restaurant">
            <h3 style="color: firebrick;">العروض المتاحة الآن</h3>
            <div class="text-center">
                <button type="button" class="btn btn-danger btn-lg">
                    <a style="display: inline" class="h2" href="{{route('getOffer')}}">أضف عرض جديد</a>
                </button>
            </div>
            <div class="container">
                <div class="row mt-4">

                    @foreach($offers as $offer)
                        <div class="col-md-6">
                            <div class="media">
                                <img src="{{asset($offer->image)}}" class="mr-3"  alt="res-img" width="50%">
                                <div class="media-body">
                                    <p><h4>{{$offer->name}} </h4></p>
                                    <div class="restaurant-content">
                                        <p class="mt-3">{{$offer->description}} </p>
                                        <p class="mt-3">{{$offer->price}} </p>
                                        <button type="button" class="btn btn-danger btn-lg m-2">
                                            <a href="{{url(route('getEditOffer',$offer->id))}}"> تعديل </a>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-lg m-2">
                                            <a href="{{url(route('deleteOffer',$offer->id))}}">  حذف </a>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endsection

    </main>









