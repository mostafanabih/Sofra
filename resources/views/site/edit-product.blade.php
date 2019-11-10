@extends('site/layout/master')
@section('content')
    @push('title')
        تعديل منتج
    @endpush



    <section class="register">
        <div class="form-section">
            @include('partials.validationerrors')
            @include('flash::message')
            {!! Form::model($model,[
                'action' => ['Front\MainController@editProduct',$model->id],
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
                <h4 style="color: #230040;margin-bottom: 2rem">صورة المنتج</h4>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" value="{{$model->name}}" name="name">
            </div>
            <div class="form-group">
                <textarea rows="5" class="form-control"  name="ingredients" >{{$model->ingredients}}</textarea>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" value="{{$model->price}}"  name="price" >
            </div>
            <div class="form-group">
                <input type="number" class="form-control" value="{{$model->order_process_time}}"  name="order_process_time" >
            </div>
            <div class="form-group">
                <input type="number" class="form-control" value="{{$model->price_on_offer}}" name="price_on_offer" >
            </div>
            <button type="submit" class="btn btn-primary">
                <a style="display: inline" >تعديل</a>
            </button>
            {!! Form::close() !!}
        </div>
        <!--form-section-->
    </section>

@endsection
