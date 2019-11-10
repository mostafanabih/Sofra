@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            المطاعم
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('admin/home')}}"><i class="fa fa-dashboard"></i> الرئيسيه</a></li>
            <li class="active">المطاعم</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="{{asset($rules->image)}}" alt="User profile picture">

                <h3 class="profile-username text-center">{{$rules->name}}</h3>

                <div class="col-sm-6">

                    <address>
                       <h4> <i class="fa fa-mail-forward" aria-hidden="true"></i> البريد الإلكتروني : {{$rules->email}} </h4><br>
                       <h4> <i class="fa fa-phone" aria-hidden="true"></i> الهاتف : {{$rules->phone}} </h4><br>
                        <h4><i class="fa fa-home" aria-hidden="true"></i> الحي : {{optional($rules->neighborhood)->name}}</h4><br>
                        <h4><i class="fa fa-bars" aria-hidden="true"></i>  التصنيف : @foreach($rules->categories as $category)
                            {{$category->name}}
                        @endforeach</h4>
                        <br>
                        <h4><i class="fa fa-money" aria-hidden="true"></i> رسوم التوصيل : {{$rules->delivery_fees}}</h4>
                        <br>
                        <h4> <i class="fa fa-sort-numeric-asc" aria-hidden="true"></i>الحد الادني : {{$rules->minimum}}</h4><br>
                    </address>
                </div>
                <div class="col-sm-3 pull-left">
                    <address>
                         <h4> <i class="fa fa-star-o" aria-hidden="true"></i>  الوضع : {{$rules->state}}</h4><br>
                        <h4><i class="fa fa-star" aria-hidden="true"></i> الحاله :{{$rules->status}}</h4><br>
                        <h4> <i class="fa fa-phone-slash" aria-hidden="true"></i><i class="fa fa-phone-square fa-2x" style="color: indianred;"></i> : {{$rules->contact_phone}}</h4><br>
                            <h4><i class="fa fa-whatsapp-square" aria-hidden="true"></i><i class="fa fa-whatsapp fa-2x" style="color: green;"></i>: {{$rules->whats_app}} </h4><br>
                    </address>
                </div>
                </div>

            </div>
            <!-- /.box-body -->
        </div>

    </section>
@endsection
