@extends('site/layout/master')
@inject('city','App\Models\City')
@section('content')
    @push('title')
        حسابي
    @endpush
    <main>

        <section class="account">
            <div class="form-section">
                @include('partials.validationerrors')
                @include('flash::message')
                <img src="{{asset($profile->image)}}" class="rounded-circle" width="30%">
                {!! Form::open([
                    'action' => ['Front\MainController@clientProfile'],
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
                        <input type="file" class="form-control-file" value="{{old('image')}}" name="image">
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
