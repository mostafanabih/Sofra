@extends('site/layout/master')
@inject('city','App\Models\City')
@inject('category', 'App\Models\Category')
<?php
$categories = $category->pluck('name', 'id')->toArray();
?>
@section('content')
    @push('title')
         حسابي
    @endpush
    <main>

        <section class="contact">
            <div class="form-section">
                @include('partials.validationerrors')
                @include('flash::message')
                <img src="{{asset($profile->image)}}" class="rounded-circle" width="30%">
                {!! Form::open([
                    'action' => ['Front\MainController@restaurantProfile'],
                    'method' => 'post',
                    'class' => 'pt-3',
                    'enctype' => 'multipart/form-data',
                    'files' => true
                ])!!}
                <div class="form-group">
                    <input type="text" class="form-control" name="name" value="{{$profile->name}}">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" value="{{$profile->email}}">
                </div>
                <div class="form-group">
                    <input type="tel" class="form-control"  name="phone" value="{{$profile->phone}}">
                </div>

                {!! Form::select('categories[]',$categories,null, [
                 'class'=>'form-control select2 ',
                 'placeholder' => 'اختر التصنيف',
                 'multiple' => 'multiple',
                 'id' => 'category'
                 ]) !!}
                {!! Form::select('city_id',$city->pluck('name', 'id')->toArray(),optional($profile->neighborhood)->city_id, [
                     'class'=>'custom-select custom-select-lg mb-3 mt-3 custom-width',
                     'id' => 'cities',
                     'placeholder' => 'اختر المدينه'
                 ]) !!}

                @inject('neighborhood', 'App\Models\Neighborhood')
                {!! Form::select('neighborhood_id',$neighborhood->pluck('name', 'id')->toArray(),$profile->neighborhood_id, [
                'class'=>'custom-select custom-select-lg mb-3 mt-3 custom-width',
                'id' => 'neighborhoods',
                'placeholder' => 'اختر الحى'
                ]) !!}


                <div class="form-group">
                    <input type="password" class="form-control" name="password"  placeholder="كلمة السر">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="تأكيد كلمة السر">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" value="{{$profile->minimum}}" name="minimum"  >
                </div>
                <div class="form-group">
                    <input type="text" class="form-control"  value="{{$profile->delivery_fees}}" name="delivery_fees" >
                </div>

                <div class="form-group">
                    <label><h4 style="color: darkblue;">بيانات التوصيل :</h4></label>

                    <div class="form-group">
                        <input type="tel" class="form-control" name="contact_phone" value="{{$profile->contact_phone}}"  >
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-control" name="whats_app" value="{{$profile->whats_app}}" >
                    </div>
                </div>

                <div class="form-group">
                    <input type="file" class="form-control-file" value="{{old('image')}}" name="image">
                </div>
                <div class="form-group radio">
                    مفتوح<input type="radio"  name="state" value="open">
                    مغلق<input type="radio" name="state"  value="close">
                </div>
                <button type="submit" class="btn btn-primary btn-lg m-3">
                    <h5>إحفظ التعديلات</h5>
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
