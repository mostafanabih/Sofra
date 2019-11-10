@extends('layouts.app')
@inject('client','App\Models\Client')
@inject('user','App\User')
@inject('cities','App\Models\City')
@inject('neighborhoods','App\Models\Neighborhood')
@inject('orders','App\Models\Order')
@inject('restaurants','App\Models\Resturant')
@inject('offers','App\Models\Offer')
@inject('reviews','App\Models\Review')
@section('content')
<section class="content-header">
    <h1>
        الصفحه الرئيسيه
    </h1>
    <ol class="breadcrumb pull-left">
        <li><a href="#"><i class="fa fa-dashboard"></i> الرئيسيه</a></li>
        <li class="active">لوحة التحكم</li>
    </ol>
</section>
<section class="content" style="margin-top: 10px;">

    <div class="row" >
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <a href="{{url(route('client.index'))}}" class="info-box-icon bg-aqua"><i class="fa fa-users red"></i> </a>
            <div class="info-box-content">
                <span class="info-box-text"><b>العملاء</b></span>
                <span class="info-box-number">{{($client->count())}}</span>
            </div>
                            <!-- /.info-box-content -->
        </div>
                        <!-- /.info-box -->
    </div>
                    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <a href="{{url(route('user.index'))}}" class="info-box-icon bg-red"><i class="fa fa-user-plus"></i></a>

            <div class="info-box-content">
                <span class="info-box-text"><b>المستخدمين</b></span>
                <span class="info-box-number">{{($user->count())}}</span>
            </div>
                            <!-- /.info-box-content -->
        </div>
                        <!-- /.info-box -->
    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <a href="{{url(route('city.index'))}}" class="info-box-icon bg-green"><i class="fa fa-building"></i></a>

            <div class="info-box-content">
                <span class="info-box-text"><b>المدن</b></span>
                <span class="info-box-number">{{($cities->count())}}</span>
            </div>
                            <!-- /.info-box-content -->
        </div>
                        <!-- /.info-box -->
    </div>
                    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <a href="{{url(route('neighborhood.index'))}}" class="info-box-icon bg-yellow"><i class="fa fa-home"></i></a>

            <div class="info-box-content">
                <span class="info-box-text"><b>الأحياء</b></span>
                <span class="info-box-number">{{($neighborhoods->count())}}</span>
            </div>
                            <!-- /.info-box-content -->
        </div>
                        <!-- /.info-box -->
    </div>

                    <!-- /.col -->
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <a href="{{url(route('order.index'))}}" class="info-box-icon bg-fuchsia"><i class="fa fa-list-ol"></i></a>

            <div class="info-box-content">
                <span class="info-box-text"><b>الطلبات</b></span>
                <span class="info-box-number">{{($orders->count())}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <!-- /.col -->
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <a href="{{url(route('restaurant.index'))}}" class="info-box-icon bg-purple"><i class="fa fa-cutlery"></i></a>

                <div class="info-box-content">
                    <span class="info-box-text"><b>المطاعم</b></span>
                    <span class="info-box-number">{{($restaurants->count())}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <a href="{{url(route('review.index'))}}" class="info-box-icon bg-black"><i class="fa fa-comments"></i></a>

                <div class="info-box-content">
                    <span class="info-box-text"><b>التعليقات والتقييم</b></span>
                    <span class="info-box-number">{{($reviews->count())}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <a href="{{url(route('offer.index'))}}" class="info-box-icon bg-gray"><i class="fa fa-shopping-bag"></i></a>

                <div class="info-box-content">
                    <span class="info-box-text"><b>العروض</b></span>
                    <span class="info-box-number">{{($offers->count())}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <!-- /.col -->
    </div>


    <div class="card">
        <div class="card-body">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="box">

                <div class="box-tools pull-left">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>

                <div class="box-body">
                    تم تسجيل دخولك بنجاح!
                </div>

            </div>

        </div>
    </div>
</section>

@endsection
