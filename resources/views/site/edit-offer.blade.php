@extends('site/layout/master')
@section('content')
    @push('title')
        إضافه عرض
    @endpush


    <section class="register add-offer">
        <h3 style="text-align: center;margin-bottom: 3rem">إضافة عرض جديد</h3>
        <div class="form-section">
            @include('partials.validationerrors')
            @include('flash::message')
            {!! Form::model($model,[
               'action' => ['Front\MainController@editOffer',$model->id],
               'method' => 'put',
               'class' => 'pt-2',
               'enctype' => 'multipart/form-data',
               'files' => true
           ])!!}
            <div class="form-group">
                <div class="image-upload mb-2">
                    <label for="file-input">
                        <img src="{{asset('web/img/images/Layer 1.png')}}" width="100%" class="image-upload1">
                    </label>
                    <input id="file-input" name="image" value="{{$model->image}}" type="file">
                </div>
                <h4 style="color: #230040;margin-bottom: 2rem">صورة العرض</h4>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="name" value="{{$model->name}}" >
            </div>
            <div class="form-group">
                <textarea rows="5" class="form-control" name="description" >{{$model->description}}</textarea>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="price" value="{{$model->price}}">
            </div>

            <div class="form-row">
                <h6 style="color: #230040;align-self: center;" class="px-2">من</h6>
                <input type="text" name="date_from" id="demo-3_1" value="{{$model->date_from}}" class="form-control-sm px-1">
                <h6 style="color: #230040;align-self: center;" class="px-2">إلى</h6>
                <input type="text" name="date_to" id="demo-3_2" value="{{$model->date_to}}" class="form-control-sm px-1">
            </div>
            <button type="submit" class="btn btn-primary">
                <a style="display: inline" href="#">تعديل</a>
            </button>
            {!! Form::close() !!}
        </div>
        <!--form-section-->
    </section>

@endsection


