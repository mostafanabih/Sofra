@extends('site/layout/master')
@section('content')
    @push('title')
        تواصل معنا
    @endpush


    <main>

        <section class="contact">
            <div class="form-section">
                <h4>تواصل معنا</h4>
                @include('partials.validationerrors')
                @include('flash::message')
                {!! Form::open([
                      'action' => ['Front\MainController@contactUs'],
                      'method' => 'post',
                      'class' => 'pt-3'
                      ]) !!}
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{old('name')}}" name="name" placeholder="الاسم كاملاً">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" value="{{old('email')}}" name="email" placeholder="البريد الإلكترونى">
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-control" value="{{old('phone')}}" name="phone"  placeholder="الجوال">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="message" value="{{old('message')}}" placeholder="ماهى رسالتك ؟" rows="4"></textarea>
                    </div>
                    <div class="form-group radio" >
                        شكوى<input type="radio" name="problem_type" value="complaint">
                        إقتراح<input type="radio" name="problem_type"  value="suggestion">
                        إستعلام<input type="radio" name="problem_type"  value="inquiry">
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg m-3">
                        <h5>إرسال</h5>
                    </button>

                {!! Form::close() !!}
            </div>

        </section>


    </main>

@endsection
