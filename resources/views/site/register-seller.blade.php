@extends('site/layout/master')
@inject('city','App\Models\City')
@inject('category', 'App\Models\Category')
<?php
$categories = $category->pluck('name', 'id')->toArray();
?>@section('content')
    @push('title')
        إنشاء حساب مطعم جديد
    @endpush

    <main class="register-bg">
        <section class="register">
            <div class="form-section">
                @include('partials.validationerrors')
                @include('flash::message')
                <img src="{{asset('web/img/images/user.png')}}" width="30%">
                {!! Form::open([
                    'action' => ['Front\AuthController@restaurantRegister'],
                    'method' => 'post',
                    'class' => 'pt-3',
                    'enctype' => 'multipart/form-data',
                    'files' => true
                ])!!}
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{old('name')}}" name="name" placeholder="الاسم">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" value="{{old('email')}}"  name="email" placeholder="البريد الالكترونى">
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-control" name="phone" value="{{old('phone')}}"  placeholder="الجوال">
                    </div>
                {!! Form::select('categories[]',$categories,null, [
                     'class'=>'form-control select2',
                     'multiple' => 'multiple',
                      'placeholder' => 'اختر القسم'
                ]) !!}
                    {!!Form::select('city_id',$city->pluck('name','id')->toArray(),null,[
                     'class' => 'form-control custom-select custom-select-lg mb-3 mt-3 custom-width',
                     'id' => 'cities',
                     'placeholder'=>'المدينه'

                    ])!!}

                    {!!Form::select('neighborhood_id',[],null,[
                        'class' => 'form-control custom-select custom-select-lg mb-3 mt-3 custom-width',
                        'id' => 'neighborhoods',
                        'placeholder'=>'الحي'

                    ])!!}
                    <div class="form-group">
                        <input type="password" class="form-control" name="password"  placeholder="كلمة السر">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="تأكيد كلمة السر">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{old('minimum')}}" name="minimum"  placeholder="الحد الادنى للطلب">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control"  value="{{old('delivery_fees')}}" name="delivery_fees" placeholder="رسوم التوصيل">
                    </div>
                    <div class="form-group">
                        <label><h4>بيانات التوصيل :</h4></label>

                    <div class="form-group">
                        <input type="tel" class="form-control" name="contact_phone" value="{{old('contact_phone')}}"  placeholder=" الهاتف">
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-control" name="whats_app" value="{{old('whats_app')}}"  placeholder="الواتس اب">
                    </div>
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control-file" name="image" >
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">بإنشاء حسابك أنت توافق على الشروط الخاصة بسفرة</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg m-3">
                        <h5>تسجيل</h5>
                    </button>

                {!! Form::close() !!}
            </div>

        </section>
    </main>
    @push('scripts')
        <script>
            $("#cities").change(function(e){
                e.preventDefault();
                var city_id = $("#cities").val();
                if(city_id)
                {
                    $.ajax({
                        url : '{{url('api/V1/neighborhoods?city_id=')}}'+city_id,
                        type : 'get',
                        success :function(data){
                            if(data.status == 1){
                                $("#neighborhoods").empty();
                                $("#neighborhoods").append('<option value="">الحي</option>');
                                $.each(data.data,function(index, neighborhood){
                                    $("#neighborhoods").append('<option value="'+neighborhood.id+'">'+neighborhood.name+'</option>');

                                });
                            }
                        },
                        error : function (jqXhr, textStatus, errorMessage){
                            alert(errorMessage);
                        }
                    });
                }else{
                    $("#neighborhoods").empty();
                    $("#neighborhoods").append('<option value="">الحي</option>');
                }
            });

        </script>
    @endpush

@endsection
