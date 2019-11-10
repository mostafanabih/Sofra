@extends('site/layout/master')
@section('content')
    @push('title')
        العروض
    @endpush

    <main>

        <section class="restaurant">
            <h3 style="color: firebrick;">العروض المتاحة الآن</h3>
            <div class="container">
                <div class="row mt-4">

                    @foreach($records as $record)
                        <div class="col-md-6">
                            <div class="media">
                                <img src="{{asset($record->image)}}" class="mr-3"  alt="res-img" width="50%">
                                <div class="media-body">
                                    <a href="restaurant.html"> <h4>{{$record->Resturant->name}} </h4></a>
                                    <div class="restaurant-content">
                                        <p class="mt-3">{{$record->description}} </p>
                                        <button type="button"  class="btn btn-danger btn-sm" >
                                            <a style="display: inline" class="h4" href="">احصل علي العرض</a>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


    </main>

    @endsection






