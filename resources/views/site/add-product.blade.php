@extends('site/layout/master')
@section('content')
    @push('title')
        إضافه منتج
    @endpush



    <section class="register">
        <div class="form-section">
            @include('partials.validationerrors')
            @include('flash::message')
            {!! Form::open([
                'action' => ['Front\MainController@addProduct'],
                'method' => 'post',
                'class' => 'pt-2',
                'enctype' => 'multipart/form-data',
                'files' => true
            ])!!}
            <div class="form-group">
                    <div class="image-upload mb-2">
                        <label for="file-input">
                            <img src="{{asset('web/img/images/Layer 1.png')}}" width="100%" class="image-upload1">
                        </label>
                        <input id="file-input" name="image" type="file">
                    </div>
                    <h4 style="color: #230040;margin-bottom: 2rem">صورة المنتج</h4>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" value="{{old('name')}}" name="name" placeholder="اسم المنتج">
                </div>
                <div class="form-group">
                    <textarea rows="5" class="form-control" value="{{old('ingredients')}}" name="ingredients" placeholder="وصف مختصر"></textarea>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" value="{{old('price')}}" name="price" placeholder="السعر">
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" value="{{old('order_process_time')}}" name="order_process_time" placeholder="مدة التجهيز">
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" value="{{old('price_on_offer')}}" name="price_on_offer" placeholder=" السعر في العرض">
                </div>
                <button type="submit" class="btn btn-primary">
                    <a style="display: inline" >إضافة</a>
                </button>
            {!! Form::close() !!}
        </div>
        <!--form-section-->
    </section>

@endsection
